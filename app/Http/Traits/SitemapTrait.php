<?php

namespace App\Http\Traits;

use App\Http\Enum\ActiveEnum;
use App\Http\Models\Einsaetze;
use App\Http\Models\Fahrzeuge;
use App\Http\Models\News;
use App\Http\Models\Seiten;
use App\Http\Models\Wachen;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/**
 * Trait SitemapTrait
 * @package App\Http\Traits
 */
trait SitemapTrait
{
    /**
     * @return array
     */
    public function getSitemapGenerator(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $pages = [];
                $subpages = $this->getSitemapChild(92);
                $pages = array_merge($pages, $subpages);
                $subpages = $this->getSitemapChild(93);
                $pages = array_merge($pages, $subpages);
                $subpages = $this->getSitemapChild(94);
                $pages = array_merge($pages, $subpages);
                return $pages;
            }
        );
        return $data;
    }

    /**
     * @param int $parent_id
     * @return array
     */
    private function getSitemapChild(int $parent_id=0): array
    {
        $pages = [];
        $PAGES = Seiten::where('parent_id', '=', $parent_id)
            ->where('show_navigation', '=', '1')
            ->where('aktiv', '=', '1')
            ->orderBy('pos', 'ASC')
            ->get();
        if (count($PAGES) === 0) {
            return [];
        }
        $PAGES->each(function ($page) use (&$pages) {
            $upages = $this->getSitemapChild($page->id);
            if ($page->link === '' || $page->link === null) {
                if ($page->page === 'fahrzeuge') {
                    $modulepages = $this->getSitemapModulVenhicles($page->page);
                    $upages = array_merge($upages, $modulepages);
                }
                if (Route::has($page->page)) {
                    $url = $this->buildPath($page->page); #'/'.$navi->page;
                } else {
                    $url = '/' . $page->page;
                }
            } else {
                $url = $page->link;
            }

            if ($page->link_target !== '') {
                $target = $page->link_target;
            }

            $pages[] = array(
                'date' => date('Y-m-d'),
                'title' => $page->title,
                'url' => $url,
                'page' => $url,
                'target' => $target,
                'upages' => $upages
            );
        });
        return $pages;
    }

    /**
     * @param $parent_id
     * @return string
     */
    public function getSitemap($parent_id)
    {
        return $this->getSitemapPageList($parent_id, 0);
    }


    public function getSitemapDetails()
    {
        $show_xml = 0;
        $xml = '';
        $xml .= $this->fahrzeuge('fahrzeugdatenbank', $show_xml);
        #$xml .= $this->wachen('fahrzeugdatenbank', $show_xml);
        $xml = $this->SitemapRepair($xml);
        return $xml;
    }

    /**
     * @param $parent_id
     * @return string
     */
    public function getSitemapXml($parent_id)
    {
        $xml = '';
        $xml .= $this->getSitemapPageListXML($parent_id, 1);
        $xml .= $this->aktuelle_news('aktuelles', 1);

        return $xml;
    }

    public function getSitemapXmlDetails()
    {
        $show_xml = 1;
        $xml = '';
        $xml .= $this->fahrzeuge('fahrzeugdatenbank', $show_xml);
        #$xml .= $this->wachen('fahrzeugdatenbank', $show_xml);
        $xml = $this->SitemapRepair($xml);
        return $xml;
    }

    private function SitemapRepair($txt)
    {
        $txt = str_replace('&Auml;', 'Ä', $txt);
        $txt = str_replace('&auml;', 'ä', $txt);
        $txt = str_replace('&Ouml;', 'Ö', $txt);
        $txt = str_replace('&ouml;', 'ö', $txt);
        $txt = str_replace('&Uuml;', 'Ü', $txt);
        $txt = str_replace('&uuml;', 'ü', $txt);
        $txt = str_replace('&szlig;', 'ß', $txt);
        return $txt;
    }

    /**
     * @param $parent_id
     * @return string
     */
    private function getSitemapPageList($parent_id, $xml = 0)
    {
        $pages = array();
        $PAGES = Seiten::where('parent_id', '=', $parent_id)
            ->where('show_navigation', '=', '1')
            ->where('aktiv', '=', '1')
            ->orderBy('pos', 'ASC')
            ->get();
        if (count($PAGES) === 0) {
            return [];
        }
        $PAGES->each(function ($page) use (&$pages, $xml) {
            $upages = $this->getSitemapPageList($page->id, $xml);
            $url = '';
            $target = '';
            if ($page->link === '' || $page->link === null) {
                if ($page->page === 'fahrzeuge') {
                    $upages .= $this->getSitemapFahrzeuge($page->page, $xml);
                }
                if (Route::has($page->page)) {
                    $url = $this->buildPath($page->page); #'/'.$navi->page;
                } else {
                    $url = '/' . $page->page;
                }
            } else {
                $url = $page->link;
            }

            if ($page->link_target !== '' && $page->link_target !== null) {
                $target = $page->link_target;
            }

            $pages[] = array(
                'date' => date('Y-m-d'),
                'title' => $page->title,
                'url' => $url,
                'page' => $url,
                'target' => $target,
                'upages' => $upages
            );
        });
        if ($xml === 1) {
            $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
        } else {
            $content = view('sitemap.sitemap_entry')->with('pages', $pages)->render();
        }
        return $content;
    }

    /**
     * @param string $page
     * @return array
     */
    private function getSitemapModulVenhicles(string $page=''): array
    {
        $pages = [];
        $FAHRZEUGE = Fahrzeuge::where('is_person', '=', ActiveEnum::Deactive)->get();
        $FAHRZEUGE->each(function ($f) use (&$pages, $page) {
            if (Route::has($page . '.details')) {
                $url = $this->buildPath($page . '.details', ['id' => $f->id]);
            } else {
                $url = '/' . $page .'/'.$f->id;
            }

            $pages[] = array(
                'date' => date('Y-m-d'),
                'title' => $f->fahrzeug,
                'url' => $url,
                'page' => $url,
                'target' => '',
                'upages' => []
            );
        });
        return $pages;
    }

    private function getSitemapFahrzeuge($page, $xml = 0)
    {
        $pages = [];
        $FAHRZEUGE = Fahrzeuge::get();
        $FAHRZEUGE->each(function ($f) use (&$pages, $page) {
            $pages[] = array(
                'date' => date('Y-m-d'),
                'title' => $f->fahrzeug,
                'url' => $this->buildPath($page . '.details', ['id' => $f->id]),
                'page' => $this->buildPath($page . '.details', ['id' => $f->id]),
                'target' => '',
                'upages' => []
            );
        });
        if ($xml === 1) {
            $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
        } else {
            $content = view('sitemap.sitemap_entry')->with('pages', $pages)->render();
        }
        return $content;
    }

    private function getSitemapNews($page, $xml = 0)
    {
        $pages = [];
        $NEWS = News::where('archive', '=', '0')->orderBy('date_time', 'DESC')->orderBy('title', 'ASC')->get();
        $NEWS->each(function ($n) use (&$pages, $page) {
            $pages[] = array(
                'date' => date('Y-m-d'),
                'title' => $this->makeDatumZeitStatic($n->datum_zeit) . ': ' . $n->title,
                'url' => $this->buildPath($page . '.details', ['id' => $n->id]),
                'page' => $this->buildPath($page . '.details', ['id' => $n->id]),
                'target' => '',
                'upages' => []
            );
        });
        if ($xml === 1) {
            $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
        } else {
            $content = view('sitemap.sitemap_entry')->with('pages', $pages)->render();
        }
        return $content;
    }

    private function getSitemapPageListXML($parent_id)
    {
        $pages = array();
        $PAGES = Seiten::where('parent_id', '=', $parent_id)
            ->where('show_navigation', '=', '1')
            ->where('link', '=', '')
            ->where('aktiv', '=', '1')
            ->orderBy('pos', 'ASC')
            ->get();
        if (count($PAGES) === 0) {
            return '';
        }
        $PAGES->each(function ($page) use (&$pages) {
            $upages = $this->getSitemapPageList($page->id, 1);
            $pages[] = array(
                'date' => date('Y-m-d'),
                'page' => $this->buildPath($page->page),
                'url' => $this->buildPath($page->page),
                'target' => '',
                'upages' => []
            );
        });
        $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
        return $content;
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    private function buildPath(string $route='', array $params=[]):string
    {
        $url = '/';
        $url.=$route;
        if (count($params)>0) {
            foreach ($params as $key => $val) {
                $url.='/'.$val;
            }
        }
        return $url;
    }

    private function feuerwehrlexikon($page, $xml = 0)
    {
        $abc = array(
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z'
        );
        $pages = [];
        for ($i = 0; $i < 26; $i++) {
            $pages[] = [
                'date' => date('Y-m-d'),
                'page' => '/' . $page . '/' . $abc[$i],
                'url' => '/' . $page . '/' . $abc[$i],
                'target' => '',
                'upages' => []
            ];
        }
        if ($xml === 1) {
            $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
        } else {
            $content = view('sitemap.sitemap_entry')->with('pages', $pages)->render();
        }
        return $content;
    }

    private function aktuelle_news($page, $xml = 0)
    {
        $pages = [];
        $NEWS = News::where('archive', '=', '0')->orderBy('date_time', 'DESC')->orderBy('title', 'ASC')->get();
        $NEWS->each(function ($n) use (&$pages, $page) {
            $geaendert = explode(' ', $n->datum_zeit);
            $geaendert = $geaendert [0];
            $pages[] = [
                'date' => $geaendert,
                'page' => $this->buildPath('news.details', ['id' => $n->id]),
                'url' => $this->buildPath('news.details', ['id' => $n->id]),
                'target' => '',
                'upages' => []
            ];
        });
        if ($xml === 1) {
            $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
        } else {
            $content = view('sitemap.sitemap_entry')->with('pages', $pages)->render();
        }
        return $content;
    }

    private function getSitemapWachenData($id)
    {
        $data = Cache::remember('wachen_data_' . $id, Config::get('CacheConfig.cache_content_timeout'), function () use ($id) {
            $data = [];
            $Wachen = Wachen::where('id', '=', $id)
                ->get();
            $Wachen->each(function ($w) use (&$data) {
                $data = $w;
            });
            return $data;
        });
        return $data;
    }

    private function wachen($page, $xml = 0)
    {
        $pages = [];
        if (Wachen::exists()) {
            $WACHEN = Wachen::orderBy('hiorg', 'ASC')->orderBy('hiort_name')->get();
            $WACHEN->each(function ($w) use (&$pages, $page) {
                $pages[] = [
                    'title' => $w->hiorg . ' ' . $w->hiort_name,
                    'target' => '',
                    'date' => date('Y-m-d'),
                    'page' => $this->buildPath('fahrzeugdatenbank.ort', ['id' => $w->id, 'ort' => $w->hiorg . ' ' . $w->hiort_name]),
                    'url' => $this->buildPath('fahrzeugdatenbank.ort', ['id' => $w->id, 'ort' => $w->hiorg . ' ' . $w->hiort_name]),
                    'upages' => [],
                ];
            });
            if ($xml === 1) {
                $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
            } else {
                $content = view('sitemap.sitemap_entry')->with('pages', $pages)->render();
            }
            return $content;
        }
        return '';
    }

    private function fahrzeuge($page, $xml = 0)
    {
        $pages = [];
        $FAHRZEUGE = Fahrzeuge::orderBy('cms_fahrzeug_ort_id', 'ASC')->get();
        $FAHRZEUGE->each(function ($f) use (&$pages, $page) {
            $station = 'Keine Zuordnung';
            if ($f->cms_fahrzeug_ort_id > 0) {
                $wache = $this->getSitemapWachenData($f->cms_fahrzeug_ort_id);
                if (is_object($wache)) {
                    $station = $wache->hiorg . ' ' . $wache->hiort_name;
                }
            }
            $ausrangiert = '';
            if ($f->ausrangiert === 1) {
                $ausrangiert = ' (außer Dienst)';
            }

            $pages[] = [
                'title' => $station . ' > ' . $f->fahrzeug . $ausrangiert,
                'target' => '',
                'date' => date('Y-m-d'),
                'page' => $this->buildPath('fahrzeuge', ['id' => $f->id, 'bezeichnung' => $f->fahrzeug]),
                'url' => $this->buildPath('fahrzeuge', ['id' => $f->id, 'bezeichnung' => $f->fahrzeug]),
                'upages' => [],
            ];
        });
        if ($xml === 1) {
            $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
        } else {
            $content = view('sitemap.sitemap_entry')->with('pages', $pages)->render();
        }
        return $content;
    }

    private function einsaetze($page, $xml = 0)
    {
        $pages = [];
        $EINSAETZE = Einsaetze::get();
        $EINSAETZE->each(function ($f) use (&$pages, $page) {
            $datum_time = explode(' ', $f->einsatz_begin);
            $datum = explode('-', $datum_time['0']);
            $pages[] = [
                'date' => date('Y-m-d'),
                'page' => $this->buildPath('einsaetze.details', ['jahr' => $datum['0'], 'view' => $f->id]),
                'url' => $this->buildPath('einsaetze.details', ['jahr' => $datum['0'], 'view' => $f->id]),
                'target' => '',
                'upages' => []
            ];
        });
        if ($xml === 1) {
            $content = view('sitemap.sitemap_xml_entry')->with('pages', $pages)->render();
        } else {
            $content = view('sitemap.sitemap_entry')->with('pages', $pages)->render();
        }
        return $content;
    }
}
