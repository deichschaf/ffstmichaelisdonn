<?php

namespace App\Http\Traits;

use App\Http\Controllers\WartungController;
use App\Http\Models\Download;
use App\Http\Models\HappyHoliday;
use App\Http\Models\Headimages;
use App\Http\Models\Seiten;
use App\Http\Models\SeitenBilder;
use App\Http\Models\SeitenContent;
use App\Http\Models\SeitenContentImage;
use App\Http\Models\SeitenContentTypes;
use App\Http\Models\SeitenDownload;
use App\Http\Models\SeitenHeadImages;
use App\Http\Models\SeitenTexte;
use App\Http\Models\Ticker;
use App\Http\Models\Widget;
use App\Http\Traits\NavigationTrait;
use Illuminate\Support\Facades\Route;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

/**
 * Trait LayoutTrait
 * @package App\Http\Traits
 */
trait LayoutTrait
{
    public static array $Placeholder = [];
    //protected $layout = 'template_main';

    /***
     * @param $content
     * @param $pagetitle
     * @param false $left_content
     * @param false $right_content
     * @param false $page
     * @return string
     */
    public function layout_content($content, $pagetitle, $left_content = false, $right_content = false, $page = false)
    {
        $wartung = new WartungController();
        $getWartung = $wartung->getWartung();
        $page_content = '';
        if ($getWartung === '') {
            $page_id = $this->getPageNow($page);
            if (Session::has(env('SESSION_ONLY_USER'))) {
                $page_content = $this->make_page($page_id, $content, $pagetitle, $left_content, $right_content, $page);
            } else {
                $page_content = $this->make_page($page_id, $content, $pagetitle, $left_content, $right_content, $page);
            }
        }
        return $page_content;
    }

    /***
     * @param $errorcode
     * @param $content
     * @param $pagetitle
     * @param false $left_content
     * @param false $right_content
     * @return string
     */
    public function layout_content_error(
        $errorcode,
        $content,
        $pagetitle,
        $left_content = false,
        $right_content = false
    ) {
        $wartung = new WartungController();
        $page_content = '';
        $getWartung = $wartung->getWartung();
        if ($getWartung === '') {
            $page_id = $this->getPageNow();

            if (Session::has(env('SESSION_ONLY_USER'))) {
                $page_content = $this->make_page_error($errorcode, $content, $pagetitle, $left_content, $right_content);
            } else {
                $page_content = $this->make_page_error($errorcode, $content, $pagetitle, $left_content, $right_content);
            }
        }
        return $page_content;
    }

    /***
     * @param $folder
     * @param $image
     * @return string
     */
    private function thumbnails($folder, $image)
    {
        $size = 250;
        $small = 'thumb_' . $image;
        $folder = public_path($folder);
        if (file_exists($folder . $small)) {
            return $small;
        } else {
            $data = [];
            $data['error'] = [];
            $data['success'] = [];
            $data = $this->IM($folder . $image, $size . 'x' . $size, $folder . $small, $data);
        }
        return $small;
    }

    /***
     * @param $upload_file
     * @param string $size
     * @param $endfile
     * @param $data
     * @return array
     */
    private function IM($upload_file, $size = '1024x768', $endfile, $data)
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

    /***
     * @param $page_id
     * @param $content
     * @param $pagetitle
     * @param false $left_content
     * @param false $right_content
     * @return string
     * @todo add page content section
     */
    private function make_page($page_id, $content, $pagetitle, $left_content = false, $right_content = false, $page = false)
    {
        $mobilnavi = '';
        $left = '';
        $right = '';
        $footer = '';
        $page_data = [];
        $page_data = Cache::remember(
            'page_id.' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $PAGE = Seiten::where('id', '=', $page_id)->get();
                $PAGE->each(
                    function ($p) use (&$page_data) {
                        $page_data = $p;
                    }
                );
                return $page_data;
            }
        );

        $pagetitle = $page_data['titel'];

        $headline = '';
        if ($page_data['show_titel'] === '1' && $page_data['titel'] !== '') {
            $headline = view('layout.__page')->with('titel', $page_data['titel'])->render();
            $headline .= '<p>&nbsp;</p>';
        }
        if ($content === '') {
            $content = $page_data['pagetext'];
        }

        if (route_is('home')) {
            $ticker_data = [];
            $Ticker = Ticker::where('aktiv', '=', '1')
                ->where('ticker_start', '<=', date('Y-m-d'))
                ->where('ticker_ende', '>=', date('Y-m-d'))
                ->get();
            if (count($Ticker) > 0) {
                $Ticker->each(function ($t) use (&$ticker_data) {
                    $ticker_data[] = ['ticker' => $t->ticker, 'link' => $t->ticker_link];
                });
                $ticker = [];
                foreach ($ticker_data as $k => $v) {
                    if ($v['link'] !== '') {
                        $ticker[] = link_to($v['link'], $v['ticker'], ['target' => '_blank']);
                    } else {
                        $ticker[] = $v['ticker'];
                    }
                }
                $content = '<MARQUEE>' . join(' +++ ', $ticker) . '</MARQUEE><br>' . $content;
            }
        }
        $oage_id = $page_data['id'];

        if (strpos(Route::currentRouteName(), 'admin.') === 0) {
            $content = $headline . $content;
        } else {
            $content = $headline . $this->getPageContent($page_data['seiten_content_type'], $content, $page_id);
        }

        $content = str_replace('<strong>', '<span class="strong">', $content);
        $content = str_replace('</strong>', '</span>', $content);

        $social_sharing = [
            'type' => 'website',
            'description' => ''
        ];
        $placeholder = self::getPlaceholder();

        $data = [];
        if (
            Route::currentRouteName() !== 'admin.page.placeholder'
            &&
            Route::currentRouteName() !== 'admin.page.placeholder.add'
            &&
            Route::currentRouteName() !== 'admin.page.placeholder.edit'
            &&
            Route::currentRouteName() !== 'admin.page.placeholder.delete'
            &&
            Route::currentRouteName() !== 'admin.page.placeholder.delete.post'
            &&
            Route::currentRouteName() !== 'admin.page.placeholder.save'
            &&
            Route::currentRouteName() !== 'admin.pages.edit'
        ) {
            $data['content'] = $this->replaceTextPlaceholder($content, $placeholder);
        } else {
            $data['content'] = $content;
        }
        $data['metatag'] = $this->buildMetatag($pagetitle, false);
        $title = '';

        if (Session::has('social_sharing.type')) {
            $social_sharing['type'] = Session::get('social_sharing.type');
        }
        if (Session::has('social_sharing.description')) {
            $social_sharing['description'] = Session::get('social_sharing.description');
        }
        if (Session::has('social_sharing.title')) {
            $title = ' - ' . Session::get('social_sharing.title');
            ;
        }
        $data['title'] = env('HOMEPAGETITEL') . ' - ' . $pagetitle . $title;
        $data['social_sharing'] = [
            'title' => env('HOMEPAGETITEL') . ' - ' . $pagetitle . $title,
            'type' => $social_sharing['type'],
            'site_name' => env('HOMEPAGETITEL'),
            'url' => \Request::url(),
            'description' => $this->replaceTextPlaceholder($social_sharing['description'], $placeholder),
            'image_url' => \Request::root() . env('HOMEPAGE_HEADER_IMAGE', ''),

        ];

        $footer = Cache::remember(
            'footer',
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                return '<div class="footer_navi">' . $this->getTopNavi() . '</div>' . $this->layout_footer();
            }
        );
        $this->setActivePage($page_id);
        $data['mobilnavi'] = $this->getMobileNavi();
        $data['topnavi'] = $this->getTopNavi();
        $data['footernavi'] = $this->getFooterNavi();
        $data['json_ld'] = $this->getJsonLd($page_id, $data);
        $data['left'] = $this->replaceTextPlaceholder($this->layout_left($left, $left_content), $placeholder);
        $data['right'] = $this->replaceTextPlaceholder($this->layout_right($right, $right_content), $placeholder);
        $data['footer'] = $this->replaceTextPlaceholder($footer, $placeholder);
        $data['adminpanel'] = $this->adminpanel();
        $data['blackday'] = '';//$this->blackday();
        $data['happy_holiday'] = $this->happy_holiday();
        $data['intern_header'] = $this->internheader();
        $data['googlekey'] = env('GOOGLE_GEOCODE_KEY');
        $data['head_image'] = $this->getPageImageData($page_id);
        $data['placeholder'] = true;
        return view('main')->with('data', $data)->render();
        #$content = view('main')->with('data', $data)->render();
        #return $this->TextRemoveTags($content, 0);
    }

    /**
     * @param $content_id
     * @param $content
     * @param $page_id
     * @return mixed|string
     */
    private function getPageContent($content_id, $content, $page_id)
    {
        if ($content_id === 1) { // text
            return $content;
        }
        if ($content_id === 2) { // text_gallery
            $page_content = $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageImages($page_id);
            return $page_content;
        }
        if ($content_id === 3) { // list_gallery
            $page_content = $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageContentImages($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageImages($page_id);
            return $page_content;
        }
        if ($content_id === 4) { // list
            $page_content = $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageContentList($page_id);
            return $page_content;
        }
        if ($content_id === 5) { // calendar_text_gallery
            $page_content = $this->getPageCalendar($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageImages($page_id);
            return $page_content;
        }
        if ($content_id === 6) { // calendar_text_gallery_contact
            $page_content = $this->getPageCalendar($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $content;
            $page_content .= $this->getPageImages($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageContact($page_id);
            return $page_content;
        }
        if ($content_id === 7) { // links
            return $this->getPageLinks($page_id);
        }
        if ($content_id === 8) { // links_logos
            return $this->getPageLinksLogos($page_id);
        }
        if ($content_id === 9) { // calendar
            return $this->getPageCalendar($page_id);
        }
        if ($content_id === 10) { // contact
            return $this->getPageContact($page_id);
        }
        if ($content_id === 11) { // text_image_gallery
            $page_content = $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageImages($page_id);
            return $page_content;
        }
        if ($content_id === 12) { // facebook_timeline
            return $this->getPageFacebookTimeline($page_id);
        }
        if ($content_id === 13) { // instagram_timeline
            return $this->getPageInstagramTimeline($page_id);
        }
        if ($content_id === 14) { // text_gallery_form
            $page_content = $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageImages($page_id);
            return $page_content;
        }
        if ($content_id === 15) { // gallery
            return $this->getPageImages($page_id);
        }
        if ($content_id === 16) { // text_download
            $page_content = $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageDownload($page_id);
            return $page_content;
        }
        if ($content_id === 17) { // text_download_gallery
            $page_content = $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageDownload($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageImages($page_id);
            return $page_content;
        }
        if ($content_id === 18) { // list_download
            $page_content = $this->getPageContentList($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageDownload($page_id);
            return $page_content;
        }
        if ($content_id === 19) { // list_download_gallery
            $page_content = $content;
            $page_content .= $this->getPageContentList($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageDownload($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageImages($page_id);
            return $page_content;
        }
        if ($content_id === 20) { // vorstand
            return $this->getVorstand($page_id);
        }
        if ($content_id === 21) { // vorstand_gallery
            $page_content = $this->getVorstand($page_id);
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getPageImages($page_id);
            return $page_content;
        }
        if ($content_id === 22) { // text_vorstand
            $page_content = $content;
            $page_content .= $this->getContentSeperator();
            $page_content .= $this->getVorstand($page_id);
            return $page_content;
        }
        if ($content_id == 23) { // downloads
            $content =$this->getPageDownload($page_id);
            return $content;
        }
        if ($content_id == 24) { // timetable
            $content = $this->getTimetable($page_id);
            return $content;
        }
        if ($content_id == 25) { // text_timetable
            $content = $content . $this->getTimetable($page_id);
            return $content;
        }
        return $content;
    }

    /***
     * @return string
     */
    private function getContentSeperator(): string
    {
        return view('partials._page_seperator')->render();
    }

    /**
     * @param $page_id
     * @return mixed
     */
    private function getPageImageData($page_id)
    {
        $page_image_data = Cache::remember(
            'page_id.headimage' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $PAGE = SeitenHeadImages::where('page_id', '=', $page_id)->get();
                $image_id = 1;
                if (count($PAGE) > 0) {
                    $PAGE->each(function ($p) use (&$image_id) {
                        $image_id = $p->headerimage_id;
                    });
                }
                $image_data = [];
                $Image = Headimages::where('id', '=', $image_id)->get();
                $Image->each(function ($hi) use (&$image_data) {
                    $image_data = [
                        'image' => $hi->image,
                        'position' => $hi->position,
                    ];
                });
                return $image_data;
            }
        );
        return $page_image_data;
    }

    private function getTimetable($page_id)
    {
        $content = Cache::remember('timetable_'.$page_id, Config::get('CacheConfig.cache_content_timeout'), function () {
            $places = [];
            $Places = TimeTablePlace::orderBy('id', 'ASC')->get();
            $Places->each(function ($p) use (&$places) {
                $places[$p->id] = $p->place;
            });
            $place_contents = '';
            foreach ($places as $k => $row) {
                $timetable = TimetableTrait::BuildTimeTable($k);
                $place_contents.=view('timetable.timetable_overview')
                    ->with('headline', $row)
                    ->with('timetable', $timetable)
                    ->render();
            }
            return $place_contents;
        });
        return $content;
    }

    private function getPageDownload($page_id)
    {
        $content = Cache::remember(
            'page_download_' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $download_ids = [];
                $PAGEDOWNLOADS = SeitenDownload::where('cms_seiten_id', '=', $page_id)->get();
                $PAGEDOWNLOADS->each(function ($sd) use (&$download_ids) {
                    $download_ids[] = $sd->cms_download_id;
                });
                if (count($download_ids) === 0) {
                    return '';
                }
                $downloads = [];
                $DOWNLOADS = Download::whereIn('id', $download_ids)
                    ->orderBy('download_titel', 'ASC')->get();
                $DOWNLOADS->each(function ($d) use (&$downloads) {
                    $file = DownloadTrait::getFilePath() . $d->download_file;
                    if (is_file($file)) {
                        $downloads[] = [
                            'title' => $d->download_title,
                            'text' => $d->download_text,
                            'key' => $d->download_key,
                            'size' => FxToolsFilesTrait::getFilesize($file),
                            'update' => $this->makeDatumZeitStatic($d->updated_at)
                        ];
                    }
                });
                if (count($download_ids) === 0) {
                    return '';
                }
                return view('pages.partials.page_downloads')->with('downloads', $downloads)->render();
            }
        );
        return $content;
    }

    /**
     * @param $page_id
     * @return mixed
     */
    private function getPageImages($page_id)
    {
        $page_images = Cache::remember(
            'page_id.' . $page_id . '.images',
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $images = [];
                $PAGE = SeitenBilder::where('page_id', '=', $page_id)
                    ->orderBy('pos', 'ASC')->get();
                $PAGE->each(
                    function ($p) use (&$images) {
                        $images[] = [
                            'title' => $p->titel,
                            'bild' => $p->bild,
                            'small' => $this->thumbnails('/images/bilder/', $p->bild),
                            'pos' => $p->pos
                        ];
                    }
                );
                if (count($images) === 0) {
                    return '';
                }
                return view('pages.partials.page_images')->with('images', $images)->render();
            }
        );
        return $page_images;
    }

    /**
     * @param $page_id
     * @return mixed
     */
    private function getPageContentList($page_id)
    {
        $content = Cache::remember(
            'page_content_list_' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $content = [];
                $Content = SeitenContent::where('page_id', '=', $page_id)
                    ->orderBy('pos')->get();
                $Content->each(function ($sc) use (&$content) {
                    $content[] = [
                        'title' => $sc->content_titel,
                        'text' => $sc->content_text, 'id' => $sc->id
                    ];
                });

                if (count($content) === 0) {
                    return '';
                }
                return view('pages.partials.page_list')->with('content', $content)->render();
            }
        );
        return $content;
    }

    /***
     * @param $page_id
     * @return string
     * @todo Build PageLinks
     */
    private function getPageLinks($page_id)
    {
        return '';
    }

    /***
     * @param $page_id
     * @return string
     * @todo Build PageLinksLogos
     */
    private function getPageLinksLogos($page_id)
    {
        return '';
    }

    /***
     * @param $page_id
     * @return string
     * @todo Build PageCalendar
     */
    private function getPageCalendar($page_id)
    {
        return '';
    }

    /***
     * @param $page_id
     * @return string
     * @todo Build PageContact
     */
    private function getPageContact($page_id)
    {
        return '';
    }

    /**
     * @param $page_id
     * @return mixed
     */
    private function getPageFacebookTimeline($page_id)
    {
        $content = Cache::remember(
            'page_content_facebook_timeline_' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $content = [];
                $Content = SeitenContent::where('page_id', '=', $page_id)
                    ->orderBy('pos')->get();
                $Content->each(function ($sc) use (&$content) {
                    $content = ['facebook_name' => $sc->content_titel, 'facebook_url' => $sc->content_url, 'id' => $sc->id];
                });
                if (count($content) === 0) {
                    return '';
                }
                return view('pages.partials.page_facebook_timeline')->with('content', $content)->render();
            }
        );
        return $content;
    }

    /**
     * @param $page_id
     * @return mixed
     */
    private function getPageInstagramTimeline($page_id)
    {
        $content = Cache::remember(
            'page_content_instagram_timeline_' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $content = [];
                $Content = SeitenContent::where('page_id', '=', $page_id)
                    ->orderBy('pos')->get();
                $Content->each(function ($sc) use (&$content) {
                    $content = ['facebook_name' => $sc->content_titel, 'facebook_url' => $sc->content_url, 'id' => $sc->id];
                });
                if (count($content) === 0) {
                    return '';
                }
                return view('pages.partials.page_facebook_timeline')->with('content', $content)->render();
            }
        );
        return $content;
    }

    /**
     * @param $page_id
     * @return mixed
     */
    private function getPageContentImages($page_id)
    {
        $content = Cache::remember(
            'page_content_images_' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $content = [];
                $Content = SeitenContentImage::where('page_id', '=', $page_id)
                    ->orderBy('pos')->get();
                $Content->each(function ($sci) use (&$content) {
                    $content[] = ['title' => $sci->content_titel, 'text' => $sci->content_text, 'image' => $sci->image, 'id' => $sci->id];
                });
                if (count($content) === 0) {
                    return '';
                }
                return view('pages.partials.page_content_image')->with('content', $content)->render();
            }
        );
        return $content;
    }

    /**
     * @param $page_id
     * @return mixed
     */
    private function getImages($page_id)
    {
        $images = Cache::remember(
            'page_images_.' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id) {
                $images = [];
                if ($page_id === '') {
                    return $images;
                }
                $Images = SeitenBilder::where('page_id', '=', $page_id)
                    ->orderBy('pos')->get();
                $Images->each(function ($imgs) use (&$images) {
                    $images[] = [
                        'image' => $imgs->bild,
                        'text' => $imgs->titel
                    ];
                });
                return $images;
            }
        );
        return $images;
    }

    /***
     * @param string $name
     * @return mixed|string
     */
    public static function ReplacePlaceholderOneName(string $name = '')
    {
        if (count(self::$Placeholder) === 0) {
            self::$Placeholder = self::getPlaceholder();
        }
        if (array_key_exists($name, self::$Placeholder)) {
            return self::$Placeholder[$name];
        }
        return '';
    }

    /**
     * @param $errocode
     * @param $content
     * @param $pagetitle
     * @param false $left_content
     * @param false $right_content
     * @return string
     */
    private function make_page_error($errocode, $content, $pagetitle, $left_content = false, $right_content = false)
    {
        $mobilnavi = '';
        $left = '';
        $right = '';
        $footer = '';
        $page_data = [];
        $page_data = [
            'title' => Session::get('errorcontentcode') . ' - ' . Session::get('errorcontenttext'),
            'pagetext' => Session::get('errorcontenttext')
        ];

        $pagetitle = $page_data['title'];
        $headline = view('layout.__page')->with('titel', $page_data['title'])->render();
        $headline .= '<p>&nbsp;</p>';
        if ($content === '') {
            $content = $page_data['pagetext'];
        }
        //$content = $headline . $page_data['pagetext'] . $content;
        $content = $headline . $content;

        $social_sharing = [
            'type' => 'website',
            'description' => ''
        ];

        $data = [];
        $data['content'] = $content;
        $data['metatag'] = $this->buildMetatag($pagetitle, false);
        $title = '';
        $data['title'] = env('HOMEPAGETITEL') . ' - ' . $pagetitle . $title;
        $data['social_sharing'] = [
            'title' => env('HOMEPAGETITEL') . ' - ' . $pagetitle . $title,
            'type' => $social_sharing['type'],
            'site_name' => env('HOMEPAGETITEL'),
            'url' => \Request::url(),
            'description' => $social_sharing['description'],
            'image_url' => \Request::root() . '/grfx/ffhennstedt.png',

        ];

        $footer = Cache::remember(
            'footer',
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($errocode) {
                return '<div class="footer_navi">' . $this->getTopNavi() . '</div>' . $this->layout_footer();
            }
        );
        $data['mobilnavi'] = $this->getMobileNavi();
        $data['topnavi'] = $this->getTopNavi();
        $data['left'] = $this->layout_left($left, $left_content);
        $data['right'] = $this->layout_right($right, $right_content);
        $data['footer'] = $footer;
        $data['adminpanel'] = $this->adminpanel();
        $data['blackday'] = ''; //$this->blackday();
        $data['happy_holiday'] = $this->happy_holiday();
        $data['intern_header'] = $this->internheader();
        $data['googlekey'] = env('GOOGLE_GEOCODE_KEY');
        $data['widget'] = $this->getWidgetContent('right');
        return view('main')->with('data', $data)->render();
    }

    /**
     * @return string
     */
    private function getPageNow($pageslug = false)
    {
        $page = '';
        #$now = URL::current();
        $now = Route::currentRoutename();
        if ($now === 'pages' && $pageslug !== false) {
            $slugs = $this->getSlugPage();
            if (count($slugs) > 0) {
                foreach ($slugs as $k => $v) {
                    if ($v === $pageslug) {
                        $now = $v;
                    }
                }
            }
        }
        $pages = Cache::remember(
            'pages_overview_controll',
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $pages = [];
                $PAGE = Seiten::where('page', '!=', '')->get();
                $PAGE->each(function ($p) use (&$pages) {
                    $pages[$p->id] = $p->page;
                });
                return $pages;
            }
        );

        foreach ($pages as $k => $val) {
            if ($now === $val) {
                $page = $k;
            }
        }

        if ($page !== '') {
            return $page;
        }
        #return Redirect::to('404');
        return '2';
    }

    /***
     * @return mixed
     */
    private function getSlugPage()
    {
        $pages = Cache::remember(
            'slug_pages',
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $pages = [];
                $PAGES = Seiten::where('page', '!=', '')->get();
                $PAGES->each(function ($p) use (&$pages) {
                    $pages[$p->id] = $p->page;
                });
                return $pages;
            }
        );
        return $pages;
    }

    /**
     * @param $page
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function getPageData($page)
    {
        $page_data = [];
        $Page = Seiten::where('page', '=', $page)->get();
        if (count($Page) === 0) {
            return redirect('404');
        }
        $Page->each(function ($p) use (&$page_data) {
        });
        return $page_data;
    }

    /***
     * @param int $page_id
     * @param array $data
     * @return mixed
     */
    private function getJsonLd($page_id = 0, $data = [])
    {
        $content = Cache::remember(
            'json_ld_page_id_' . $page_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id, $data) {
                $json_data =  [];
                $json_data['content'] = $this->TextRemoveTags($data['content'], 1);
                $json_data['social_sharing'] = $data['social_sharing'];
                $content = view('partials.json_ld')->with('data', $json_data)->render();
                return $this->TextRemoveTags($content, 0);
            }
        );
        return $content;
    }

    /***
     * @param string $content
     * @param int $strip_tag
     * @return array|string|string[]|null
     */
    private function TextRemoveTags($content = '', $strip_tag = 1)
    {
        if ($strip_tag === 1) {
            $content = strip_tags($content);
        }
        $content = str_replace('&nbsp;', ' ', $content);
        $content = str_replace("&nbsp;", ' ', $content);
        $content = preg_replace('/\/\*(.|\n)*?\*\//m', '', $content);
        $content = preg_replace('/\r\n|\n/m', '', $content);
        $content = str_replace(array(PHP_EOL, "\t"), '', $content);
        $content = preg_replace('|\s\s+|', ' ', $content);
        return $content;
    }

    /**
     * @param $left
     * @param bool $left_content
     * @return string
     */
    private function layout_left($left, $left_content = false)
    {
        $content = '';
        $content .= $this->getLeftNavi3();
        $Widget = $this->getWidgetContent('left');
        $content .= $Widget;
        $content .= '<div class="p-b-10"></div>';
        return $content;
    }

    /**
     * @param $right
     * @param bool $right_content
     * @return string
     */
    private function layout_right($right, $right_content = false)
    {
        $content = '';
        #$content.= $this->showLastEinsatz();
        #$content.= $this->showPartner();
        $Widget = $this->getWidgetContent('right');
        $content .= $Widget;
        return $content;
    }

    /***
     * @param string $position
     * @return mixed
     */
    private function getWidgetContent($position = 'right')
    {
        $Widget = Cache::remember(
            $position . '_widget',
            Config::get('CacheConfig.cache_navi_timeout'),
            function () use ($position) {
                $content = '';
                $Widget = Widget::where('active', '=', '1')
                    ->where('position', '=', $position)
                    ->orderBy('pos', 'ASC')->get();
                $Widget->each(function ($p) use (&$content) {
                    if ($content !== '') {
                        $content .= '<div class="p-b-10"></div>';
                    }
                    $content .= $this->getWidget($p->WidgetName, $p->param);
                });
                return $content;
            }
        );
        return $Widget;
    }

    /**
     * @return string
     */
    private function internheader()
    {
        return '';
    }

    /**
     * @return string
     */
    private function adminpanel()
    {
        return '';
    }

    /***
     * Checkt ob es einen Schwarzen Tag in der Geschichte gegeben hat, dann zeige alles zum Schwarzen Tag
     * @return boolean
     */
    private function blackday()
    {
        $heute = date('Y-m-d');

        $blackday = Cache::remember(
            'blackday.' . $heute,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($heute) {
                $blackday = [];
                $Blackday = Blackday::where('blackday', '=', $heute)->get();
                $Blackday_show = Blackday::where('datum_von', '<=', $heute)
                    ->where('datum_bis', '>=', $heute)->get();
                $Blackday->each(function ($b) use (&$blackday) {
                    $blackday[] = [
                        'title' => $b->title,
                        'text' => $b->text,
                    ];
                });
                $Blackday_show->each(function ($b) use (&$blackday) {
                    $blackday[] = [
                        'title' => $b->title,
                        'text' => $b->text2,
                    ];
                });
                return $blackday;
            }
        );
        return $blackday;
    }

    /**
     * @return mixed
     */
    private function happy_holiday()
    {
        $heute = date('Y-m-d');
        $holiday = Cache::remember(
            'holiday.' . $heute,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($heute) {
                $holiday = '';
                $Holiday = HappyHoliday::where('beginn', '<=', $heute)
                    ->where('end', '>=', $heute)->get();
                $Holiday->each(function ($h) use (&$holiday) {
                    $holiday = $h->template;
                });
                return $holiday;
            }
        );
        return $holiday;
    }

    /**
     * @return string
     */
    private function layout_footer()
    {
        $data = [];
        return view('layout.footer')->with('data', $data)->render();
    }

    /**
     *
     */
    private function makeAutoRoutes()
    {
        $files = [];
        $Pages = Page::where('activ', '=', '1')
            ->where('page', '!=', '')->get();
        $file = App::path() . '/autoroute.php';
        if (is_file($file)) {
            unlink($file);
        }
    }

    /***
     * @param $id
     * @return string
     */
    private function getPageContentType($id)
    {
        $pagetype = 'text';
        $SeitenContentType = SeitenContentTypes::where('id', '=', $id)->get();
        $SeitenContentType->each(function ($sct) use (&$pagetype) {
            $pagetype = $sct->pagecontenttype;
        });
        return $pagetype;
    }

    /***
     * @return array
     */
    public function PageContentTypes()
    {
        $pagetypes = [];
        $SeitenContentTypes = SeitenContentTypes::orderBy('pos', 'ASC')->get();
        $SeitenContentTypes->each(function ($sct) use (&$pagetypes) {
            $pagetypes[$sct->id] = $sct;
        });
        return $pagetypes;
    }
}
