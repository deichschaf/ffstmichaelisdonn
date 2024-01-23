<?php

namespace App\Http\Traits;

use App\Http\Models\Seiten;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/**
 * Trait NavigationTrait
 * @package App\Http\Traits
 */
trait NavigationTrait
{
    /**
     * Variabeln definieren
     */
    public $page;
    /**
     * @var string
     */
    private $ActivePage = '';
    /**
     * @var string
     */
    private $ActiveTop = '';
    /**
     * @var string
     */
    private $NaviHomeId = '2';
    /**
     * @var string
     */
    private $NaviTopId = '93';
    /**
     * @var string
     */
    private $NaviLeftId = '92';
    /**
     * @var string
     */
    private $NaviFooterId = '94';
    private $ServiceUrlId = '256';

    /**
     * Hole aktive Seite
     */
    public function getAktivPage()
    {
        #echo 'AktivPage: '.$this->aktivpage;

        return $this->ActivePage;
    }

    /**
     * @param $id
     */
    public function setActivePage($id)
    {
        $this->ActivePage = $id;
    }

    /**
     * Hole TopLink
     *
     * @return string
     */
    public function getAktivTop()
    {
        #echo 'AktivTop: '.$this->aktivtop;
        return $this->ActiveTop;
    }

    /**
     * @return string
     */
    public function getTopNavi()
    {
        $topnavi = array();
        if (count($topnavi) > 0) {
            $topnavi = join(' | ', $topnavi);
        } else {
            $topnavi = '';
        }
        return $topnavi;
    }

    /**
     * @param int $ServicePageId
     * @return array
     */
    public function getServiceUrls(int $ServicePageId = 0): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($ServicePageId) {
                $data = [];
                $Seiten = Seiten::where('parent_id', '=', $ServicePageId)
                    ->where('show_navigation', '=', '1')
                    ->where('aktiv', '=', '1')
                    ->OrderBy('pos', 'ASC')
                    ->get();
                if (count($Seiten) == 0) {
                    return $data;
                }
                $Seiten->each(function ($navi) use (&$data) {
                    $target = '';
                    if ($navi->link_target !== "" && $navi->link_target !== null) {
                        $target = $navi->link_target;
                    }
                    $data[] = [
                        'title' => $navi->navi_title,
                        'target' => $target,
                        'url' => '/' . $navi->page,
                        0];
                });
                return $data;
            }
        );
        return $data;
    }

    public function getMainNavi()
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $Seiten = Seiten::where('parent_id', '=', $this->NaviLeftId)
                    ->where('show_navigation', '=', '1')
                    ->where('aktiv', '=', '1')
                    ->OrderBy('pos', 'ASC')
                    ->get();
                if (count($Seiten) == 0) {
                    return $data;
                }
                $Seiten->each(function ($navi) use (&$data) {
                    $active = '';
                    if ($this->ActivePage === $navi->id) {
                        $active = 'current';
                    }
                    $subnavi = [];
                    $target = '';
                    if ($navi->link_target !== "" && $navi->link_target !== null) {
                        $target = $navi->link_target;
                    }
                    $subnavi[] = [
                        'url' => '/' . $navi->page,
                        'title' => $navi->navi_title,
                        'target' => $target
                    ];
                    $data[] = [
                        'title' => $navi->navi_title,
                        'className' => $active,
                        'subnavi' => $subnavi
                    ];
                });
                return $data;
            }
        );
        return $data;
    }

    public function getFooterNavi($parent_id = 0)
    {
        if ($parent_id === 0) {
            $parent_id = $this->NaviFooterId;
        }
        $FOOTERNAVI = Cache::remember('navigation.footernavi', Config::get('CacheConfig.cache_navi_timeout'), function () use ($parent_id) {
            $footernavi = '';
            $Seiten = Seiten::where('parent_id', '=', $parent_id)
                ->where('show_navigation', '=', '1')
                ->where('aktiv', '=', '1')
                ->OrderBy('pos', 'ASC')
                ->get();
            $Seiten->each(function ($navi) use (&$footernavi) {
                $active = '';
                if ($this->ActivePage === $navi->id) {
                    $active = 'active';
                }
                $options = [];
                if ($navi->link !== '' && $navi->link !== null && $navi->link !== 'NULL') {
                    $link = $navi->link;
                    $link = str_replace('&', '&amp;', $link);
                    $options[] = 'target="_blank"';
                    $options[] = 'rel="noopener noreferrer"';
                } else {
                    if (Route::has($navi->page)) {
                        $link = route($navi->page); #'/'.$navi->page;
                    } else {
                        $link = '/' . $navi->page;
                    }
                }
                $footernavi .= '<li><a class="' . $active . '" href="' . $link . '" ' . join(' ', $options) . '>' .
                    $navi->navi_title . '</a>';
                $footernavi .= $this->getFooterNavi($navi->id);
                $footernavi .= '</li>';
            });
            return $footernavi;
        });
        return $FOOTERNAVI;
    }

    /**
     * Navi mit UnterNavi Anzeigen
     * @todo Navigation für Session User anzeigen!!!
     */
    public function getLeftNavi3($login = 0)
    {
        if (Session::has(env('SESSION_ONLY_USER', 'session_user'))) {
            $login = 1;
        }
        $Navifation = Cache::remember('navigation.' . $login, Config::get('CacheConfig.cache_navi_timeout'), function () use ($login) {
            return $this->getLeftNaviWithOutCache($login);
        });
        return $Navifation;
    }

    /**
     * @param int $login
     * @return string
     */
    private function getLeftNaviWithOutCache($login = 0)
    {
        $leftnavi = '';
        if ($login === '1') {
            $Seiten = Seiten::where('parent_id', '=', $this->NaviLeftId)
                ->where('systempage', '=', '0')
                ->where('show_intern', '=', '1')
                ->where('aktiv', '=', '1')
                ->OrderBy('pos', 'ASC')
                ->get();
        } else {
            $Seiten = Seiten::where('parent_id', '=', $this->NaviLeftId)
                ->where('systempage', '=', '0')
                ->where('show_navigation', '=', '1')
                ->where('aktiv', '=', '1')
                ->OrderBy('pos', 'ASC')
                ->get();
        }
        #FxToolsTrait::debug( FxToolsTrait::getSQL() );
        $Seiten->each(
            function ($navi) use (&$leftnavi) {
                $active = '';
                if ($this->ActivePage === $navi->id) {
                    $active = 'active';
                }
                $options = [];
                if ($navi->link !== '' && $navi->link !== null && $navi->link !== 'NULL') {
                    $link = $navi->link;
                    $link = str_replace('&', '&amp;', $link);
                    $options[] = 'target="_blank"';
                    $options[] = 'rel="noopener noreferrer"';
                } else {
                    if (Route::has($navi->page)) {
                        $link = route($navi->page); #'/'.$navi->page;
                    } else {
                        $link = '/' . $navi->page;
                    }
                }
                $leftnavi .= '<li><a class="' . $active . '" href="' . $link . '" ' . join(' ', $options) . '>' .
                    $navi->navi_title . '</a>';
                $leftnavi .= $this->getLeftUnavi3($navi->id);
                $leftnavi .= '</li>';
            }
        );
        $leftnavi = '<ul id="menu">' . $leftnavi . '</ul>';
        return $leftnavi;
    }

    /**
     *
     * @param $parent_id
     * @return string
     * @todo Navigation für Session User anzeigen!!!
     */
    private function getLeftUnavi3($parent_id)
    {
        $unavi = '';
        if (Session::has(env('SESSION_ONLY_USER', 'session_user'))) {
            $Seiten = Seiten::where('parent_id', '=', $parent_id)
                ->where('systempage', '=', '0')
                ->where('show_intern', '=', '1')
                ->where('aktiv', '=', '1')
                ->OrderBy('pos', 'ASC')
                ->get();
        } else {
            $Seiten = Seiten::where('parent_id', '=', $parent_id)
                ->where('systempage', '=', '0')
                ->where('show_navigation', '=', '1')
                ->where('aktiv', '=', '1')
                ->OrderBy('pos', 'ASC')
                ->get();
        }
        #FxToolsTrait::debug( FxToolsTrait::getSQL() );
        $Seiten->each(
            function ($navi) use (&$unavi) {
                $active = '';
                if ($this->ActivePage === $navi->id) {
                    $active = 'active';
                }
                $options = [];
                if ($navi->link !== '' && $navi->link !== null && $navi->link !== 'NULL') {
                    $link = $navi->link;
                    $link = str_replace('&', '&amp;', $link);
                    $options[] = 'target="_blank"';
                    $options[] = 'rel="noopener noreferrer"';
                } else {
                    if (Route::has($navi->page)) {
                        $link = route($navi->page); #'/'.$navi->page;
                    } else {
                        $link = '/' . $navi->page;
                    }
                }
                $unavi .= '<li><a class="' . $active . '" href="' . $link . '" ' . join(' ', $options) . '>- ' . $navi->navi_title
                    . '</a></li>';
            }
        );
        if ($unavi !== '') {
            $unavi = '<div><ul>' . $unavi . '</ul></div>';
        }
        return $unavi;
    }

    /**
     * @return mixed
     */
    public function getMobileNavi()
    {
        $page = $this->ActivePage;

        $mobilenavi = Cache::remember('mobile_navigation', Config::get('CacheConfig.cache_navi_timeout'), function () {
            $class = "";
            if ($this->ActivePage === 2) {
                $class = 'active';
            }
            #$mobilenavi = '<li class="nav-item nav-link '.$class.'"><a href="/">Home</a></li>';
            $mobilenavi = '<li class="nav-item ' . $class . '"><a class="nav-link" href="/">Home</a></li>';
            $mobilenavi .= $this->getMobileUnternavi($this->NaviLeftId, 0);
            $mobilenavi .= $this->getMobileUnternavi($this->NaviTopId, 0);
            $mobilenavi = str_replace('index.php/', '', $mobilenavi);
            return $mobilenavi;
        });
        return $mobilenavi;
    }

    /***
     * @param $parent_id
     * @return string
     * @todo Navigation für Session User anzeigen!!!
     */
    private function getMobileUnternavi($parent_id, $unav = 0)
    {
        $unavi = '';

        $Seiten = Seiten::where('parent_id', '=', $parent_id)
            ->where('id', '!=', $this->NaviHomeId)
            ->where('id', '!=', $this->NaviLeftId)
            ->where('id', '!=', $this->NaviTopId)
            ->where('systempage', '=', '0')
            ->where('show_navigation', '=', '1')
            ->where('aktiv', '=', '1')
            ->OrderBy('pos', 'ASC')
            ->get();
        $Seiten->each(
            function ($navi) use (&$unavi, $unav) {
                $class = '';
                if ($navi->link !== '' && $navi->link !== null && $navi->link !== 'NULL') {
                    $link = $navi->link;
                    $link = str_replace('&', '&amp;', $link);
                    $options = [];
                    $options[] = 'target="_blank"';
                    $options[] = 'rel="noopener noreferrer"';
                } else {
                    if (Route::has($navi->page)) {
                        $link = route($navi->page); #'/'.$navi->page;
                    } else {
                        $link = '/' . $navi->page;
                    }
                    $options = [];
                }

                if ($this->ActivePage === $navi->id) {
                    $class = "active";
                } elseif ($this->ActiveTop === $navi->id) {
                    $class = "active";
                }

                $unavi2 = $this->getMobileUnternavi($navi->id, 1);

                if ($unavi2 !== '') {
                    $unavi .= '<li class="nav-item dropdown">';
                    $unavi .= '<a class="nav-link dropdown-toggle" href="' . $link . '" id="navbardrop' . $navi->id . '" data-toggle="dropdown">'
                        . $navi->navi_title . '</a>';
                    $unavi .= '<div class="dropdown-menu">';
                    $unavi .= $unavi2;
                    $unavi .= '</div>';
                    $unavi .= '</li>';
                } else {
                    if ($unav === 0) {
                        $unavi .= '<li class="nav-item"><a class="nav-link ' . $class . '" href="' . $link . '" ' . join(' ', $options)
                            . '>'
                            . $navi->navi_title . '</a></li>';
                    } else {
                        $unavi .= '<a class="nav-item ' . $class . '" onclick="loadURL(this.href)" href="' .
                            $link . '" ' . join(
                                ' ',
                                $options
                            ) . '>'
                            . $navi->navi_title . '</a>';
                    }
                }
            }
        );
        if ($unavi !== '' && $parent_id !== $this->NaviTopId && $parent_id !== $this->NaviLeftId) {
            #$unavi = '<div class="dropdown-item dropdown">'.$unavi.'</div>';
        }
        return $unavi;
    }

    /**
     * @return array
     */
    public function getMobileNaviReact(): array
    {
        $data = [];
        $data[] = [
            'link' => '/',
            'title' => 'Home',
            'options' => [],
            'subnavi' => [],
        ];
        $unaviLeft = $this->getMobileUnternaviReact($this->NaviLeftId, 0);
        $unaviTop = $this->getMobileUnternaviReact($this->NaviTopId, 0);
        return array_merge($data, $unaviLeft, $unaviTop);
    }

    /**
     * @param int $parent_id
     * @param int $unav
     * @return array
     */
    private function getMobileUnternaviReact(int $parent_id = 0, int $unav = 0): array
    {
        $data = [];

        $Seiten = Seiten::where('parent_id', '=', $parent_id)
            ->where('id', '!=', $this->NaviHomeId)
            ->where('id', '!=', $this->NaviLeftId)
            ->where('id', '!=', $this->NaviTopId)
            ->where('systempage', '=', '0')
            ->where('show_navigation', '=', '1')
            ->where('aktiv', '=', '1')
            ->OrderBy('pos', 'ASC')
            ->get();
        $Seiten->each(
            function ($navi) use (&$data, $unav) {
                $class = '';
                if ($navi->link !== '' && $navi->link !== null && $navi->link !== 'NULL') {
                    $link = $navi->link;
                    $link = str_replace('&', '&amp;', $link);
                } else {
                    if (Route::has($navi->page)) {
                        $link = route($navi->page); #'/'.$navi->page;
                    } else {
                        $link = '/' . $navi->page;
                    }
                    $options = [];
                }

                if ($this->ActivePage === $navi->id) {
                    $class = "active";
                } elseif ($this->ActiveTop === $navi->id) {
                    $class = "active";
                }

                $unavi2 = $this->getMobileUnternaviReact($navi->id, 1);

                if ($unavi2 !== '') {
                    $data[] = [
                        'link' => $link,
                        'title' => $navi->navi_title,
                        'id' => $navi->id,
                        'target' => $navi->link_target,
                        'rel' => "noopener noreferrer",
                        'subnavi' => $unavi2,
                    ];
                } else {
                    if ($unav === 0) {
                        $data[] = [
                            'link' => $link,
                            'title' => $navi->navi_title,
                            'id' => $navi->id,
                            'target' => $navi->link_target,
                            'rel' => "noopener noreferrer",
                            'subnavi' => [],
                        ];
                    } else {
                        $data[] = [
                            'link' => $link,
                            'title' => $navi->navi_title,
                            'id' => $navi->id,
                            'target' => $navi->link_target,
                            'rel' => "noopener noreferrer",
                            'subnavi' => [],
                        ];
                    }
                }
            }
        );
        return $data;
    }

    private function getSubMain($parent_id = 0): array
    {
        $Seiten = Seiten::where('parent_id', '=', $parent_id)
            ->where('show_navigation', '=', '1')
            ->where('aktiv', '=', '1')
            ->OrderBy('pos', 'ASC')
            ->get();
        $data = [];
        if (count($Seiten) == 0) {
            return $data;
        }
        $Seiten->each(function ($navi) use (&$data) {
            $active = '';
            if ($this->ActivePage === $navi->id) {
                $active = 'current';
            }
            $target = '';
            if ($navi->link_target !== "" && $navi->link_target !== null) {
                $target = $navi->link_target;
            }
            $data[] = [
                'url' => '/' . $navi->page,
                'title' => $navi->navi_title,
                'target' => $target
            ];
        });
        return $data;
    }

    /***
     * Queries minify
     * @param int $parent_id
     */
    private function getNaviTree($parent_id = 0)
    {
    }
}
