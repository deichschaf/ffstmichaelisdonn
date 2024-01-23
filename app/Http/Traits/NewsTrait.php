<?php

namespace App\Http\Traits;

use App\Http\Models\News;
use App\Http\Models\NewsPresse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

/**
 * Trait NewsTrait
 * @package App\Http\Traits
 */
trait NewsTrait
{
    public function getAdminNews():array
    {
        $data=[];
        $getNews = News::orderBy('created_at', 'DESC')->get();
        $getNews->each(function ($n) use (&$data) {
            $article = $this->NewsTextReplace($n->article);
            $data[] = [
                'id' => $n->id,
                'title' => $n->title,
                'subtitle' => $n->subtitle,
                'article' => $this->getShort($article, 2),
                'created_at' => $this->makeDatumZeitStatic($n->created_at),
                'source_id' => $n->tel_cms_news_quell_id,
                'active' => $n->active,
                'link' => $n->link,
                'picture' => $n->picture,
                'picturetext' => $n->picturetext,
                'source' => $n->source,
                'news_zeitung' => $n->news_zeitung,
            ];
        });
        return $data;
    }
    public function getNewsList():array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $news = [];
                $News = News::where('active', '=', '1')
                    ->where('archive', '=', '0')
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('title', 'ASC')
                    ->get();

                $News->each(function ($n) use (&$news) {
                    $article = $this->NewsTextReplace($n->article);
                    $news[] = [
                        'id' => $n->id,
                        'title' => $n->title,
                        'subtitle' => $n->subtitle,
                        'article' => $this->getShort($article, 2),
                        'created_at' => $this->makeDatumZeitStatic($n->created_at),
                        'source_id' => $n->tel_cms_news_quell_id,
                        'link' => $n->link,
                        'picture' => $n->picture,
                        'picturetext' => $n->picturetext,
                        'source' => $n->source,
                        'news_zeitung' => $n->news_zeitung,
                    ];
                });
                return $news;
            }
        );
        return $data;
    }

    /**
     * @param int $archiv
     * @return array
     */
    public static function news_show($archiv = 0)
    {
        $data = [];
        $data['title'] = 'News';
        $news = [];
        $News = News::where('active', '=', '1')
            ->orderBy('created_at', 'DESC')
            ->orderBy('title', 'ASC')
            ->get();

        $News->each(function ($n) use (&$news) {
            $article = self::NewsTextReplace($n->article);
            $news[] = [
                'id' => $n->id,
                'title' => $n->title,
                'subtitle' => $n->subtitle,
                'article' => $this->getShort($article, 2),
                'created_at' => $this->makeDatumZeitStatic($n->created_at),
                'source_id' => $n->tel_cms_news_quell_id,
                'link' => $n->link,
                'picture' => $n->picture,
                'picturetext' => $n->picturetext,
                'source' => $n->source,
                'news_zeitung' => $n->news_zeitung,
            ];
        });
        $data['news'] = $news;
        $content = view('news.news')->with('data', $data)->render();
        return array('content' => $content, 'title' => $data['title']);
    }

    private static function NewsTextReplace($txt)
    {
        $txt = str_replace('\n', ' ', $txt);
        $txt = str_replace('\r', ' ', $txt);
        $txt = str_replace('&shy;', '', $txt);
        return $txt;
    }

    /**
     * @param int $archiv
     * @return array
     */
    public static function news_show_trait($archiv = 0)
    {
        $data = [];
        $data['title'] = 'News';
        $news = [];
        $News = News::where('active', '=', '1')
            ->orderBy('created_at', 'DESC')
            ->orderBy('title', 'ASC')
            ->get();
        $News->each(function ($n) use (&$news) {
            $date = explode(' ', $n->created_at);
            $datum_lang = FxToolsTrait::datum_ausgeschrieben(FxToolsTrait::datum_de_static($date['0']));
            $article = self::NewsTextReplace($n->article);
            $news[] = array(
                'id' => $n->id,
                'title' => $n->title,
                'subtitle' => $n->subtitle,
                'article' => self::getShortText($article, 2),
                'created_at' => $this->makeDatumZeitStatic($n->created_at),
                'datum_lang' => $datum_lang,
                'source_id' => $n->tel_cms_news_quell_id,
                'link' => $n->link,
                'picture' => $n->picture,
                'picturetext' => $n->picturetext,
                'source' => $n->source,
                'news_zeitung' => $n->news_zeitung,
            );
        });
        $data['news'] = $news;
        $content = view('news.news')->with('data', $data)->render();
        return array('content' => $content, 'title' => $data['title']);
    }

    public static function getStaticShortText($txt, $lines)
    {
        return $txt;
    }

    /**
     * @param $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function getStaticNews($id)
    {
        $data = [];
        $data['title'] = 'News';
        $news = [];
        $News = News::where('active', '=', '1')->where('id', '=', $id)->get();
        if (count($News) === 0) {
            return redirect('news');
        }
        $News->each(function ($n) use (&$news) {
            $article = self::NewsTextReplace($n->article);
            Session::put('social_sharing.title', FxToolsTrait::makegetFacebookDescription($n->title));
            Session::put('social_sharing.description', FxToolsTrait::makegetFacebookDescription($article));
            $news = array(
                'title' => $n->title,
                'subtitle' => $n->subtitle,
                'article' => $article,
                'created_at' => $n->created_at,
                'source_id' => $n->tel_cms_news_quell_id,
                'link' => $n->link,
                'picture' => $n->picture,
                'picturetext' => $n->picturetext,
                'source' => NewsTrait::getPresseInfo($n->cms_news_source_id),
                'news_zeitung' => $n->news_zeitung,
            );
        });
        if (count($news) === 0) {
            return [];
        }
        $data['news'] = $news;
        $content = view('news.news_eintrag')->with('data', $data)->render();
        return array('content' => $content, 'title' => $data['title']);
    }

    /**
     * @param $id
     * @return string
     */
    public static function getStaticPresseInfo($id)
    {
        if ($id === 0) {
            return '';
        }

        $NEWSPRESSE = NewsPresse::where('id', '=', $id)->get();
        if (count($NEWSPRESSE) === 0) {
            return '';
        }
        $html = new HtmlBuilder();
        $source = [];
        $NEWSPRESSE->each(function ($p) use (&$source, $html) {
            if ($p->firma !== '' && $p->firma !== null) {
                $source[] = '<b>' . $p->firma . '</b>';
            }
            if ($p->abteilung !== '' && $p->abteilung !== null) {
                $source[] = $p->abteilung;
            }
            if ($p->funktion !== '' && $p->funktion !== null) {
                $source[] = $p->funktion;
            }
            if ($p->nachname !== '' && $p->nachname !== null) {
                $name = '';
                if ($p->vorname !== '' && $p->vorname !== null) {
                    $name = $p->vorname . ' ';
                }
                $source[] = '<b>' . $name . $p->nachname . '</b>';
            }
            if ($p->strasse !== '' && $p->strasse !== null) {
                $source[] = $p->strasse;
            }
            if ($p->ort !== '' && $p->ort !== null) {
                $ort = '';
                if ($p->plz !== '' && $p->plz !== null) {
                    $ort = $p->plz . ' ';
                }
                $source[] = $ort . $p->ort;
            }
            if ($p->telefon !== '' && $p->telefon !== null) {
                $source[] = $p->telefon;
            }
            if ($p->telefon2 !== '' && $p->telefon2 !== null) {
                $source[] = $p->telefon2;
            }
            if ($p->telefax !== '' && $p->telefax !== null) {
                $source[] = 'Fax: ' . $p->telefax;
            }
            if ($p->mobil !== '' && $p->mobil !== null) {
                $source[] = $p->mobil;
            }
            if ($p->emailadresse !== '' && $p->emailadresse !== null) {
                $source[] = $html->mailto($p->emailadresse);
            }
            if ($p->emailadresse2 !== '' && $p->emailadresse2 !== null) {
                $source[] = $html->mailto($p->emailadresse2);
            }
            if ($p->homepage !== '' && $p->homepage !== null) {
                $source[] = '<a href="' . FxToolsTrait::Tools_buildUrl($p->homepage) . '" target="_blank">' . $p->homepage . '</a>';
            }
        });

        $source = join('<br>', $source);
        return $source;
    }

    /**
     * @param $param
     * @return array
     */
    public function getLastNews($param): array
    {
        $news = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () use ($param) {
                $news = [];
                $datum = date('Y-m-d', mktime(0, 0, 0, (date('m') - 1), date('d'), date('Y')));
                $News = News::where('created_at', '>=', $datum . ' 00:00:00')->where('active', '=', '1')->orderBy('created_at', 'DESC')->orderBy('title', 'ASC')->take($param)->get();
                $News->each(function ($n) use (&$news) {
                    $morelink = null;
                    $moreextern = null;
                    if ($n->article !== '' && $n->article !== '<br>' && $n->article !== 'NULL' && $n->article !== null) {
                        $morelink=$n->news_id;
                    }
                    if ($n->link !== '' && $n->link !== '<br>' && $n->link !== 'NULL' && $n->link !== null) {
                        $moreextern= $n->link;
                    }
                    $news[] = [
                        'date' => $this->makeDatumZeitStatic($n->created_at),
                        'title' => $n->title,
                        'newstext' => $n->article,
                        'morelink' => $morelink,
                        'moreextern' => $moreextern,
                    ];
                });
                return $news;
            }
        );
        return $news;
    }
}
