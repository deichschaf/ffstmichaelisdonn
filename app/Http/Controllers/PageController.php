<?php

namespace App\Http\Controllers;

use App\Http\Models\CacheModel;
use App\Http\Models\Headimages;
use App\Http\Models\Layout;
use App\Http\Models\Seiten;
use App\Http\Models\SeitenBilder;
use App\Http\Models\SeitenContent;
use App\Http\Models\SeitenError;
use App\Http\Models\SeitenHeadImages;
use App\Http\Models\SeitenTexte;
use App\Http\Traits\ImageTrait;
use App\Http\Traits\PageTrait;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

/**
 * Class PageController
 * @package App\Http\Controllers
 */
class PageController extends GroundController
{
    public function checkOffline(): JsonResponse
    {
        $client = new Client();
        try {
            $res = $client->request('GET', 'https://www.google.com', ['connect_timeout' => 1, 'verify' => false]);
            $data = [
                'success' => true,
                'code' => $res->getStatusCode()
            ];
            return response()->json($data, 200);
        } catch (ConnectException $exception) {
            $data = [
                'success' => false,
                'code' => $exception->getCode(),
                'error' => [
                    'message' => 'Offline',
                    'code' => $exception->getCode()
                ]];
            return response()->json($data, 200);
        }
        $data = [
            'success' => false,
            'code' => 500,
            'error' => [
                'message' => 'Offline',
                'code' => 500
            ]];
        return response()->json($data, 500);
    }

    public function pageOverviewApi(): JsonResponse
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () {
                $data = [];
                $data['pages'] = $this->getListPages();
                $data['pagecontenttypes'] = $this->getPageContentTypes();
                $data['form_add_url'] = $this->getAdminPath() . '/page/add';
                $data['form_edit_url'] = $this->getAdminPath() . '/page/edit';
                $data['form_edittitle_url'] = $this->getAdminPath() . '/page/edittitle';
                $data['form_delete_url'] = $this->getAdminPath() . '/page/delete';
                $data['form_save_url'] = '/api' . $this->getAdminPath() . '/page/save';
                return $data;
            }
        );
        return response()->json($data, 200);
    }

    public function placeholderOverview(): JsonResponse
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () {
                $data = [];
                $data['placeholder'] = $this->getPlaceholderAdmin();
                $data['form_add_url'] = $this->getAdminPath() . '/placeholder/add';
                $data['form_edit_url'] = $this->getAdminPath() . '/placeholder/edit';
                $data['form_save_url'] = '/api' . $this->getAdminPath() . '/placeholder/save';
                return $data;
            }
        );
        return response()->json($data, 200);
    }

    /**
     * For Cookie Read
     * return redirect back
     */
    public function SetReadCookie($cookie = 'ReadCookieInformation')
    {
        $newcookie = false;
        if (!Cookie::has($cookie)) {
            $expire = 365 * 20 * 24 * 60 * 60;
            try {
                $newcookie = Cookie::make($cookie, '1', $expire, \Config::get('session.path'), \Config::get('session.domain'), \Config::get('session.secure'), \Config::get('session.http_only'));
            } catch (Exception $e) {
            }
        }
        return back(301)->withCookie($newcookie);
    }

    public function showApagerStore()
    {
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            // android
            $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
            if (stripos($ua, 'android') !== false) { // && stripos($ua,'mobile') !== false) {
                header('Location: https://play.google.com/store/apps/details?id=org.xcrypt.apager.android2');
                exit();
            }
            // ipad
            $isiPad = (bool)strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
            // iphone/ipod
            if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPod')) {
                header('Location: https://itunes.apple.com/de/app/apager-pro/id958761234?mt=8');
                exit();
            }
        }
        return redirect()->route('react');
    }

    /***
     * @return RedirectResponse
     * @todo Clear Cache Files in Storage!!!!
     */
    public function makeCacheClear($redirect = 1)
    {
        $cache = CacheModel::where('value', '!=', '')->delete();
        $cache2 = Artisan::call('cache:clear');
        #$cache3 = Artisan::call('debugbar:clear');
        $cache4 = Artisan::call('view:clear');
        $cache5 = Artisan::call('view:clear');
        if (1 === $redirect) {
            return back()->with('cache', 'Cache erfolgreich geleert');
        }
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
    }

    public function makeArtianCalls()
    {
        $data = [];
        $data[] = $this->makeArtisanCall('blutspende:termine');
        $data[] = $this->makeArtisanCall('criticalreader:nina');
        $data[] = $this->makeArtisanCall('criticalreader:load');
        $data[] = $this->makeArtisanCall('criticalreader:newssender');
        $data[] = $this->makeArtisanCall('dwd:warn');
        return response()->json($data, 200);
    }

    private function makeArtisanCall(string $call): array
    {
        $data = [];
        $data['call'] = $call;
        try {
            Artisan::queue($call);
            $data['code'] = 200;
        } catch (Exception $e) {
            $data['error'] = $e->getCode();
            $data['message'] = $e->getMessage();
            $data['code'] = $e->getCode();
        }
        return $data;
    }

    /**
     * @param string $slug
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * @return JsonResponse
     */
    public function getContent(string $slug = '', string $param1 = '', string $param2 = '', string $param3 = ''): JsonResponse
    {
        try {
            $slug = strtolower($slug);
            if ($slug === 'start' || $slug === '') {
                $slug = 'home';
            }

            $count = Seiten::where('page', '=', $slug)->count();
            if ($count === 0) {
                $data = [];
                $data['data'] = [];
                $data['error'] = 404;
                $data['message'] = 'Page not Found!';
                $data['code'] = 404;
                $data['seiten_content_type'] = 0;
                $data['pagecontenttype'] = 0;
                return response()->json($data, $data['code']);
            }

            $data = [];
            $getPageContent = Seiten::where('page', '=', $slug)->get();
            $getPageContent->each(function ($p) use (&$data) {
                if ($p->seiten_content_type === 45) {
                    //return redirect($p->link, 301);
                    $data['data'] = [];
                    $data['error'] = 301;
                    $data['message'] = 'Moved Permanently';
                    $data['code'] = 301;
                    $data['seiten_content_type'] = 45;
                    $data['pagecontenttype'] = 45;
                    $data['redirect'] = $p->link;
                }
            });
            if (count($data) > 0) {
                return response()->json($data, $data['code']);
            }


            $data = Cache::remember(
                __CLASS__ . '_' . __FUNCTION__ . '_SLUG_' . $slug . '_p1_' . $param1 . '_p2_' . $param2 . '_p3_' . $param3,
                Config::get('CacheConfig.cache_content_timeout'),
                function () use ($slug, $param1, $param2, $param3) {
                    $data = [];
                    $data['data'] = [];
                    $data['slug'] = $slug;
                    $data['pagecontenttype'] = -1;
                    $getPageContent = Seiten::where('page', '=', $slug)->get();
                    $getPageContent->each(function ($p) use ($param1, $param2, $param3, &$data) {
                        $data['data'] = $this->getPage($p->id);
                        $data['pagecontenttype'] = $data['data']['pagecontenttype'];
                        $data['title'] = $data['data']['title'];
                        $data['data']['blackday'] = (array)$this->getBlackdayContent();
                        if (in_array($data['pagecontenttype'], [26, 27]) && $param1 !== '' && $param2 !== "") {
                            $emergencydetail = $this->getEmergencyDetails($param1, $param2);
                            if ($emergencydetail !== []) {
                                $data['pagecontenttype'] = 28;
                                $data['data']['pagecontenttype'] = 28;
                                $data['data']['seiten_content_type'] = 28;
                            }
                        }
                        if (in_array($data['pagecontenttype'], [29, 30]) && $param1 !== '') {
                            $vehiclesdetail = $this->getVehiclesDetails($param1, $param2);
                            if ($vehiclesdetail !== []) {
                                $data['pagecontenttype'] = 31;
                                $data['data']['pagecontenttype'] = 31;
                                $data['data']['seiten_content_type'] = 31;
                            }
                        }

                        if ($data['slug'] === 'home' || $data['slug'] === 'start') {
                            $data['data']['hydrantcheck'] = $this->getHydrantCheck();
                            $data['data']['happyholiday'] = $this->getWidgetHoliday();
                            $data['data']['danceball'] = $this->getDanceBall();
                            $data['data']['annualgeneralmeeting'] = $this->getGeneralMeeting();
                            $data['data']['news'] = $this->getLastNews(6);
                            $data['data']['statistic'] = $this->getStartStatistic();
                        }

                        if (in_array($data['pagecontenttype'], [2, 3, 5, 6, 11, 14, 15, 17, 19, 21])) {
                            $data['data']['gallery'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [3, 4, 18, 19])) {
                            $data['data']['list'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [5, 6, 9])) {
                            $data['data']['calendar'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [6, 10])) {
                            $data['data']['contact'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [7])) {
                            $data['data']['links'] = $this->getLinks();
                        }
                        if (in_array($data['pagecontenttype'], [8])) {
                            $data['data']['linkslogo'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [11])) {
                            $data['data']['image'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [12])) {
                            $data['data']['facebooktimeline'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [13])) {
                            $data['data']['instagramtimeline'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [14])) {
                            $data['data']['form'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [16, 17, 18, 19, 23, 43])) {
                            $data['data']['downloads'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [20, 21, 22])) {
                            $data['data']['management'] = (array)$this->getManagement();
                        }
                        if (in_array($data['pagecontenttype'], [24, 25])) {
                            $data['data']['timetable'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [26, 27])) {
                            $data['data']['emergency'] = $this->getEmergencies();
                        }
                        if (in_array($data['pagecontenttype'], [28])) {
                            $data['data']['emergencydetail'] = $emergencydetail;
                            $data['data']['emergencyarea'] = $this->getEmergencyArea();
                        }
                        if (in_array($data['pagecontenttype'], [29, 30])) {
                            $data['data']['verhicles'] = (array)$this->getVehicles();
                        }
                        if (in_array($data['pagecontenttype'], [31])) {
                            $data['data']['verhicledetail'] = $vehiclesdetail;
                        }
                        if (in_array($data['pagecontenttype'], [32, 33])) {
                            $data['data']['sitemap'] = $this->getSitemapGenerator();
                        }
                        if (in_array($data['pagecontenttype'], [34, 35])) {
                            $data['data']['scheduler'] = $this->getScheduler();
                        }
                        if (in_array($data['pagecontenttype'], [36, 37])) {
                            $data['data']['news'] = $this->getNewsList();
                        }
                        if (in_array($data['pagecontenttype'], [38, 39])) {
                            $data['data']['newsdetail'] = $this->getScheduler();
                        }
                        if (in_array($data['pagecontenttype'], [40])) {
                            $data['data']['emergency_statistic'] = $this->getEmergencyStatistics();
                        }
                        if (in_array($data['pagecontenttype'], [41])) {
                            $data['data']['emergencyarea'] = $this->getEmergencyArea();
                        }
                        if (in_array($data['pagecontenttype'], [42, 43])) {
                            $data['data']['emergencyarea'] = null;
                        }
                        if (in_array($data['pagecontenttype'], [44])) {
                            $data['data']['telephonenumber'] = $this->getTelephoneNumbers();
                        }
                    });
                    return $data;
                }
            );

            $data['code'] = 200;
            return response()->json($data, $data['code']);
        } catch (Exception $e) {
            $data = [];
            $data['error'] = $e->getCode();
            $data['message'] = $e->getMessage();
            $data['code'] = $e->getCode();
            $data['seiten_content_type'] = -1;
            $data['pagecontenttype'] = -1;

            $data['data'] = $data;
            return response()->json($data, 500);
        }
    }

    public function getWarningsApi(Request $request): JsonResponse
    {
        $page = '';
        $data = Cache::remember(
            'getWarningsApi',
            Config::get('CacheConfig.cache_warnings'),
            function () use ($page) {
                $data = [];
                $data['data'] = [
                    'critical' => (array)$this->getCritical(),
                    'weather' => (array)$this->getWeather(),
                    'blooddonation' => (array)json_decode($this->getBloodDonationTermine()),
                ];
                return $data;
            }
        );
        return response()->json($data, 200);
    }

    public function getPagedataApi(Request $request)
    {
        $path = [];
        $path['0'] = '';
        if ($request->has('path')) {
            $path = substr($request->get('path'), 1, -1);
            $path = explode('/', $path);
        }
        $page = $path['0'];
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $page,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () use ($page) {
                $widgets = $this->getWidgets();
                $data = [];
                $data['header'] = [
                    'mainnavi' => $this->getMobileNaviReact(),
                ];
                $data['footer'] = [
                    'homepageTitle' => env('HOMEPAGE_TITLE', ''),
                    'homepageCopyright' => env('HOMEPAGE_COPY_START', date('Y')) . ' - ' . date('Y'),
                    'serviceurls' => (array)$this->getServiceUrls(256),
                    'contact' => (array)$this->getContactPlaceholder(),
                ];
                if ($this->getIsBlackDay() > 0) {
                    $images = ['blackday'];
                    $img = 0;
                } else {
                    $images = ['01', '02', '03', '04', '05', '06'];
                    $img = random_int(0, (count($images) - 1));
                }
                $data['page'] = [
                    'headimages' => [
                        'img' => $images[$img] . '-small.jpg',
                        'images' => [
                            [
                                'image' => $images[$img] . '-x-high.jpg',
                                'type' => 'jpg',
                                'media' => '(min-width: 721px)',
                            ],
                            [
                                'image' => $images[$img] . '-x-high.png',
                                'type' => 'png',
                                'media' => '(min-width: 721px)',
                            ],
                            [
                                'image' => $images[$img] . '-x-high.webp',
                                'type' => 'webp',
                                'media' => '(min-width: 721px)',
                            ],
                            [
                                'image' => $images[$img] . '-high.jpg',
                                'type' => 'jpg',
                                'media' => '(min-width: 641px)',
                            ],
                            [
                                'image' => $images[$img] . '-high.png',
                                'type' => 'png',
                                'media' => '(min-width: 641px)',
                            ],
                            [
                                'image' => $images[$img] . '-high.webp',
                                'type' => 'webp',
                                'media' => '(min-width: 641px)',
                            ],
                            [
                                'image' => $images[$img] . '-medium.jpg',
                                'type' => 'jpg',
                                'media' => '(min-width: 321px)',
                            ],
                            [
                                'image' => $images[$img] . '-medium.png',
                                'type' => 'png',
                                'media' => '(min-width: 321px)',
                            ],
                            [
                                'image' => $images[$img] . '-medium.webp',
                                'type' => 'webp',
                                'media' => '(min-width: 321px)',
                            ],
                        ],
                    ],
                ];
                $data['data'] = [
                    'last_emergency' => $this->showLastEinsatz(),
                    'widgets' => $widgets,
                    'fire_department_statistic' => $this->getFireDepartmentStatistic(),
                    'blackday' => $this->getBlackdayContent(),
                ];
                foreach ($widgets as $position => $subkeys) {
                    foreach ($subkeys as $k => $value) {
                        if ($value['element'] === 'WidgetTermine') {
                            $data['data']['termine'] = $this->getWidgetTermine($value['params']);
                        }
                        if ($value['element'] === 'WidgetHoliday') {
                            if ($page === '') {
                                $data['data']['happyholiday'] = $this->getWidgetHoliday();
                            } else {
                                $data['data']['happyholiday'] = [];
                            }
                        }
                    }
                }
                return $data;
            }
        );
        return response()->json($data, 200);
    }

    /**
     * @return RedirectResponse
     */
    public function setFacebookDeactive()
    {
        Cookie::queue('show_facebook', '0', $this->setCookieLifetime());
        return back()->with('cookie', 'Cookie show_facebook entfernt');
    }

    /**
     * @return int
     */
    private function setCookieLifetime()
    {
        return 2628000; // 1 Monat
    }

    /**
     * @return RedirectResponse
     */
    public function setFacebookActive()
    {
        Cookie::queue('show_facebook', '1', $this->setCookieLifetime());
        return back()->with('cookie', 'Cookie show_facebook aktiviert');
    }

    /**
     * @return RedirectResponse
     */
    public function setInstagramDeactive()
    {
        Cookie::queue('show_instagram', '0', $this->setCookieLifetime());
        return back()->with('cookie', 'Cookie show_instagram entfernt');
    }

    /**
     * @return RedirectResponse
     */
    public function setInstagramActive()
    {
        Cookie::queue('show_instagram', '1', $this->setCookieLifetime());
        return back()->with('cookie', 'Cookie show_instagram aktiviert');
    }

    public function sitemap_xml()
    {
        #$content = Cache::remember('sitemapxml', Config::get('CacheConfig.cache_navi_timeout'), function() {
        $data = [];
        $data['title'] = 'Sitemap';
        $entries = '';
        $entries .= $this->getSitemapXml(92);
        $entries .= $this->getSitemapXml(93);
        $entries .= $this->getSitemapXmlDetails();
        $data['entries'] = $entries;
        #return view('sitemap.sitemap_xml')->with('data', $data)->render();
        echo view('sitemap.sitemap_xml')->with('data', $data)->render();
        #});
        #echo $content;
        exit();
    }

    public function admin()
    {
        return view('adminlayout')->render();
    }

    public function app()
    {
        return view('applayout')->render();
    }

    public function home()
    {
        return view('mainlayout')->render();
    }

    /**
     * @param int $errorcode
     * @return string
     */
    public function content_error($errorcode = 404)
    {
        $data = [];
        $ErrorContent = SeitenError::where('errorcode', '=', $errorcode)->get();
        if (count($ErrorContent) === 0) {
            $ErrorContent = SeitenError::where('errorcode', '=', 500)->get();
        }
        $ErrorContent->each(function ($c) use (&$data) {
            $data['errorcode'] = $c->errorcode;
            $data['errortitel'] = $c->errortitel;
            $data['errortext'] = $c->errortext;
        });
        $l = new Layout();
        return $l->layout_content_error($errorcode, '', '', false, false);
    }

    /***
     * @return string
     */
    public function adminShow()
    {
        $data = [];
        $data['title'] = 'Admin Seiten';
        $data['entries'] = PageTrait::getStaticPages(92);
        $data['content_types'] = PageTrait::getPageContentTypes();
        $content = view('pages.overview')
            ->with('data', $data)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN SEITEN');
    }

    /***
     * @return string
     */
    public function admin_sort_show()
    {
        $data = [];
        $data['title'] = 'Admin Seiten';
        $data['entries'] = PageTrait::getStaticPages();
        $content = view('pages.overview_sort')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN SEITEN');
    }

    /**
     *
     */
    public function add()
    {
    }

    /***
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $page = PageTrait::getPage($id);
        $headerimages = [];
        $HEADERIMAGES = Headimages::orderBy('id', 'ASC')->get();
        $HEADERIMAGES->each(function ($hi) use (&$headerimages) {
            $headerimages[$hi->id] = $hi->image;
        });

        $content = view('pages.add_edit')
            ->with('data', $page)
            ->with('headerimages', $headerimages)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN SEITEN');
    }

    /**
     * @param $id
     * @return string
     */
    public function editheadline($id)
    {
        $page = PageTrait::getPage($id);

        $content = view('pages.add_edit_headline')
            ->with('data', $page)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN SEITEN');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveheadline(Request $request)
    {
        $inputs = $request->all();
        foreach ($inputs as $key => $value) {
            $inputs[$key] = trim($value);
        }
        $Page = PageTrait::SavePageHeadline($inputs);
        $this->clearPageCache();
        return redirect()->route('admin.pages');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPageImages(Request $request)
    {
        $request = $request->all();
        $images = [];
        $SeitenBilder = SeitenBilder::where('page_id', '=', $request['page_id'])->orderBy('pos')->get();
        $SeitenBilder->each(function ($imgs) use (&$images) {
            $images[] = [
                'image' => $imgs->bild,
                'small' => $this->admin_thumbnails('/images/bilder/', $imgs->bild),
                'text' => $imgs->titel,
                'picture_id' => $imgs->id,
            ];
        });
        return response()->json(['images' => $images]);
    }

    /**
     * @param $folder
     * @param $image
     * @return string
     */
    private function admin_thumbnails($folder, $image)
    {
        $size = 150;
        $small = 'thumb_admin_' . $image;
        $folder = public_path($folder);
        if (file_exists($folder . $small)) {
            return $small;
        } else {
            $data = [];
            $data['error'] = [];
            $data['success'] = [];
            $data = $this->admin_IM($folder . $image, $size . 'x' . $size, $folder . $small, $data);
        }
        return $small;
    }

    /**
     * @param $upload_file
     * @param string $size
     * @param $endfile
     * @param $data
     * @return array
     */
    private function admin_IM($upload_file, $size = '1024x768', $endfile, $data)
    {
        $im_config = [];
        $im_config[] = '-resize ' . $size;
        #$im_config[] = '-sampling-factor 4:2:0';
        $im_config[] = '-strip';
        #$im_config[] = '-quality 85';
        #$im_config[] = '-interlace';
        #$im_config[] = '-colorspace RGB';

        $cmd = "convert " . $upload_file . " " . implode(" ", $im_config) . " " . $endfile;
        exec($cmd, $output, $return_var);

        if (isset($output)) {
            if (count($output) > 0) {
                $data['error'][] = $output;
            }
        }
        return $data;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function deletePageImages(Request $request)
    {
        $request = $request->all();
        $path = public_path('/images/bilder/');
        $Data = SeitenBilder::where('id', '=', $request['picture_id'])->where('page_id', '=', $request['page_id'])->get();
        $Data->each(function ($f) use ($path) {
            @unlink($path . $f->bild);
            @unlink($path . 'thumb_' . $f->bild);
            @unlink($path . 'thumb_admin_' . $f->bild);
        });
        $delete = SeitenBilder::where('id', '=', $request['picture_id'])->where('page_id', '=', $request['page_id'])->delete();
        $this->clearPageCache();
        return response()->json(['success' => 'OK']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editPageImages(Request $request)
    {
        $request = $request->all();
        $Data = SeitenBilder::where('id', '=', $request['picture_id'])->where('page_id', '=', $request['page_id'])->update(['title' => $request['text']]);
        $this->clearPageCache();
        return response()->json(['success' => 'OK']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function savePageImageTitle(Request $request)
    {
        $request = $request->all();
        $picture_id = $request['picture_id'];
        $save = SeitenBilder::find($picture_id);
        $save->text = $request['text'];
        $save->save();
        $this->clearPageCache();
        return response()->json(['success' => 'OK']);
    }

    /***
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request)
    {
        $inputs = $request->all();
        foreach ($inputs as $key => $value) {
            $inputs[$key] = trim($value);
        }
        $Page = PageTrait::SavePage($inputs);
        $this->clearPageCache();
        return redirect()->route('admin.pages');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadPageImages(Request $request)
    {
        $config = [];
        $config['size'] = '1024x768';
        $data = ImageTrait::UploaderImage('/images/bilder/', 'file', $config, $request);
        $page_id = $request->input('page_id');

        if (count($data['error']) == 0) {
            $last_pos = 0;
            $Last = SeitenBilder::where('page_id', '=', $page_id)->orderBy('pos', 'DESC')->get();
            $Last->each(function ($p) use (&$last_pos) {
                $last_pos = $p->pos;
            });
            $last_pos = $last_pos + 1;
            $save = new SeitenBilder();
            $save->titel = '';
            $save->bild = $data['image'];
            $save->page_id = $page_id;
            $save->pos = $last_pos;
            $save->save();
        }
        $this->clearPageCache();
        return response()->json($data);
    }

    /**
     * @return string
     */
    public function show_headimages()
    {
        $headerimages = [];
        $counter = [];
        $default_image = [];
        $HEADERIMAGES = Headimages::orderBy('id', 'ASC')->get();
        $HEADERIMAGES->each(function ($hi) use (&$headerimages, &$counter, &$default_image) {
            $headerimages[$hi->id] = $hi->image;
            $counter[$hi->id] = 0;
            $default_image[$hi->id] = $hi->default_image;
        });

        $PageHeadImage = SeitenHeadImages::orderBy('id', 'ASC')->get();
        $PageHeadImage->each(function ($shi) use (&$counter) {
            $counter[$shi->headerimage_id] = $counter[$shi->headerimage_id] + 1;
        });

        $content = view('pages.headimages_overview')
            ->with('headerimages', $headerimages)
            ->with('counter', $counter)
            ->with('default_image', $default_image)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN HEADIMAGES');
    }

    /**
     * @return string
     */
    public function add_headimages()
    {
        $content = view('pages.headimages_add')
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN HEADIMAGES');
    }

    /**
     * @param $id
     * @return string
     */
    public function edit_headimages($id)
    {
        $data = [];
        $HEADERIMAGES = Headimages::where('id', '=', $id)->get();
        $HEADERIMAGES->each(function ($hi) use (&$data) {
            $data = $hi;
        });
        $content = view('pages.headimages_edit')
            ->with('data', $data)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN HEADIMAGES');
    }

    /**
     * @param $id
     * @return string
     */
    public function delete_headimages($id)
    {
        $data = [];
        $HEADERIMAGES = Headimages::where('id', '=', $id)->get();
        $HEADERIMAGES->each(function ($hi) use (&$data) {
            $data = $hi;
        });
        $content = view('pages.headimages_delete')
            ->with('data', $data)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN HEADIMAGES');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete_headimages_post(Request $request)
    {
        $inputs = $request->all();
        $HEADERIMAGES = Headimages::where('id', '=', $inputs['id'])->delete();
        $this->clearPageCache();
        return redirect()->route('admin.pages.images');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save_edit_headimages(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('image_title');
        $text = $request->input('image_text');
        $default = $request->input('default');
        $position = $request->input('position');

        $save = Headimages::find($id);
        $save->position = $position;
        $save->image_title = $title;
        $save->image_text = $text;
        $save->save();

        if ($default === 1) {
            Headimages::where('default_image', 1)->update(['default_image' => 0]);
            $save = Headimages::find($id);
            $save->default_image = '1';
            $save->save();
        }
        $this->clearPageCache();
        return redirect()->route('admin.pages.images');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save_headimages(Request $request)
    {
        $titel = $request->input('titel');
        $text = $request->input('image_text');
        $config = [];
        $config['filename'] = $this->filename($titel);
        $data = ImageTrait::UploaderImage('/grfx/', 'bild', $config, $request);

        $save = new Headimages();
        $save->image = $data['image'];
        $save->image_title = $titel;
        $save->image_text = $text;
        $save->position = '50% 34%';
        $save->save();
        $this->clearPageCache();
        return redirect()->route('admin.pages.images');
    }

    /**
     * @param $filename
     * @return array|string|string[]
     */
    private function filename($filename)
    {
        $filename = strtolower($filename);
        $filename = str_replace('%', '_', $filename);
        $filename = str_replace(' ', '_', $filename);
        $filename = str_replace('ä', 'ae', $filename);
        $filename = str_replace('ö', 'oe', $filename);
        $filename = str_replace('ü', 'ue', $filename);
        $filename = str_replace('ß', 'ss', $filename);
        $filename = str_replace('?', '_', $filename);
        return $filename;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getContentTexts(Request $request)
    {
        $page_id = $request->input('page_id');
        $data = [];
        $PageContents = SeitenContent::where('page_id', '=', $page_id)->orderBy('pos', 'ASC')->get();
        $PageContents->each(function ($pc) use (&$data) {
            $data[] = [
                'id' => $pc->id,
                'title' => $pc->content_title,
                'text' => $pc->content_text,
                'pos' => $pc->pos
            ];
        });
        return response()->json(['contents' => $data]);
    }

    /**
     * @param Request $request
     */
    public function content_add(Request $request)
    {
    }

    /**
     * @param Request $request
     */
    public function content_edit(Request $request)
    {
    }

    /**
     * @param Request $request
     */
    public function content_delete(Request $request)
    {
    }

    /**
     * @param Request $request
     */
    public function content_delete_post(Request $request)
    {
    }

    /**
     * @param Request $request
     */
    public function content_save(Request $request)
    {
    }

    /**
     * @param Request $request
     */
    public function content_pos(Request $request)
    {
    }

    /**
     * @return string
     */
    public function placeholder_overview()
    {
        $placeholders = [];
        $SeitenTexte = SeitenTexte::orderBy('id', 'ASC')->get();
        $SeitenTexte->each(function ($st) use (&$placeholders) {
            $placeholders[] = [
                'id' => $st->id,
                'title' => $st->placeholder_name,
                'text' => $st->placeholder_text
            ];
        });

        $content = view('pages.placeholder_overview')
            ->with('placeholders', $placeholders)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN PLACEHOLDER');
    }

    /**
     * @return string
     */
    public function placeholder_add()
    {
        $data = [];
        $data['id'] = 0;
        $data['title'] = '';
        $data['text'] = '';
        $content = view('pages.placeholder_add_edit')
            ->with('data', $data)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN PLACEHOLDER');
    }

    /**
     * @param $id
     * @return string
     */
    public function placeholder_edit($id)
    {
        $data = [];
        $SeitenTexte = SeitenTexte::where('id', '=', $id)->get();
        $SeitenTexte->each(function ($st) use (&$data) {
            $data = [
                'id' => $st->id,
                'title' => $st->placeholder_name,
                'text' => $st->placeholder_text
            ];
        });
        $content = view('pages.placeholder_add_edit')
            ->with('data', $data)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'ADMIN PLACEHOLDER');
    }

    /**
     * @param Request $request
     */
    public function placeholder_delete(Request $request)
    {
    }

    /**
     * @param Request $request
     */
    public function placeholder_delete_post(Request $request)
    {
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function placeholder_save(Request $request)
    {
        $id = $request->input('id');
        $placeholder_title = $request->input('placeholder_title');
        $placeholder_text = $request->input('placeholder_text');
        if ($id === 0) {
            $save = new SeitenTexte();
            $save->placeholder_name = $placeholder_title;
            $save->placeholder_text = $placeholder_text;
            $save->save();
        } else {
            $save = SeitenTexte::find($id);
            $save->placeholder_text = $placeholder_text;
            $save->save();
        }
        $this->clearPageCache();
        return redirect()->route('admin.page.placeholder');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete_post($id)
    {
        $page = PageTrait::DelPage($id);
        return redirect('admin.pages.overview', 302);
    }

    /**
     *
     */
    public function page_position($id, $parent_id, $pos)
    {
    }

    /**
     *
     */
    public function page_image()
    {
    }

    /**
     * @param $id
     */
    public function save_image($id)
    {
    }

    /**
     *
     */
    public function add_image()
    {
    }

    /**
     * @param $id
     */
    public function getpageInfos($id)
    {
    }

    /**
     * Protokoll über Bearbeitungszeiten und status was geändert wurde
     * @param $id
     */
    public function getAdminProtokoll($id)
    {
    }
}
