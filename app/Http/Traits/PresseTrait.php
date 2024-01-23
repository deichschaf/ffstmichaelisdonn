<?php

namespace App\Http\Traits;

use App\Http\Models\Presse;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Support\Facades\Session;

trait PresseTrait
{
    /**
     * @param int $archiv
     * @return array
     */
    public static function news_show($archiv = 0)
    {
        $data = array();
        $data['title'] = 'Presse';
        $news = array();
        $Presse = Presse::where('aktiv', '=', '1')->where('archiv', '=', $archiv)->orderBy('datum', 'DESC')->orderBy('titel', 'ASC')->get();
        $Presse->each(function ($n) use (&$news) {
            $news[] = array(
                'id' => $n->id,
                'title' => $n->titel,
                'untertitel' => $n->untertitel,
                'artikel' => $this->getShort($n->artikel, 2),
                'datum_zeit' => FxToolsTrait::datum_zeit($n->datum_zeit),
                'datum' => FxToolsTrait::datum_de_static($n->presse_datum),
                'quelle_id' => $n->tel_cms_news_quell_id,
                'link' => $n->link,
                'bild' => $n->bild,
                'bildunterschrift' => $n->bildunterschrift,
                'quelle' => $n->quelle,
                'news_zeitung' => $n->news_zeitung,
                'news_link' => $n->news_link,
            );
        });
        $data['news'] = $news;
        $content = view('news.news')->with('data', $data)->render();
        return array('content' => $content, 'title' => $data['title']);
    }

    /**
     * @param int $archiv
     * @return array
     */
    public static function admin_news_show($archiv = 0)
    {
        $data = array();
        $data['title'] = 'Presse';
        $news = array();
        $Presse = Presse::where('aktiv', '=', '1')->where('archiv', '=', $archiv)->orderBy('datum', 'DESC')->orderBy('titel', 'ASC')->get();
        $Presse->each(function ($n) use (&$news) {
            $news[] = array(
                'id' => $n->id,
                'title' => $n->titel,
                'untertitel' => $n->untertitel,
                'artikel' => $this->getShort($n->artikel, 2),
                'datum_zeit' => FxToolsTrait::datum_zeit($n->datum_zeit),
                'datum' => FxToolsTrait::datum_de_static($n->presse_datum),
                'quelle_id' => $n->tel_cms_news_quell_id,
                'link' => $n->link,
                'bild' => $n->bild,
                'bildunterschrift' => $n->bildunterschrift,
                'quelle' => $n->quelle,
                'news_zeitung' => $n->news_zeitung,
                'news_link' => $n->news_link,
            );
        });
        $data['news'] = $news;
        $content = view('news.news_overview')->with('data', $data)->render();
        return array('content' => $content, 'title' => $data['title']);
    }

    public static function getStaticPresse($id)
    {
        $data = array();
        $data['title'] = 'Presse';
        $news = array();
        $Presse = Presse::where('aktiv', '=', '1')->where('id', '=', $id)->get();
        if (count($Presse) == 0) {
            return redirect('news');
        }
        $Presse->each(function ($n) use (&$news) {
            session(['social_sharing.title' => FxToolsTrait::makegetFacebookDescription($n->titel)]);
            session(['social_sharing.description' => FxToolsTrait::makegetFacebookDescription($n->artikel)]);
            $news = array(
                'title' => $n->titel,
                'untertitel' => $n->untertitel,
                'artikel' => $n->artikel,
                'datum_zeit' => $n->datum_zeit,
                'datum' => $n->presse_datum,
                'quelle_id' => $n->tel_cms_news_quell_id,
                'link' => $n->link,
                'bild' => $n->bild,
                'bildunterschrift' => $n->bildunterschrift,
                'quelle' => PresseTrait::getPresseInfo($n->cms_news_quelle_id),
                'news_zeitung' => $n->news_zeitung,
                'news_link' => $n->news_link,
            );
        });
        if (count($news) == 0) {
            return array();
        }
        $data['news'] = $news;
        $content = view('news.news_eintrag')->with('data', $data)->render();
        return array('content' => $content, 'title' => $data['title']);
    }

    public static function getStaticPresseInfo($id)
    {
        if ($id == 0) {
            return '';
        }

        $NEWSPRESSE = PressePresse::where('id', '=', $id)->get();
        if (count($NEWSPRESSE) == 0) {
            return '';
        }
        $html = new HtmlBuilder();
        $quelle = array();
        $NEWSPRESSE->each(function ($p) use (&$quelle, $html) {
            if ($p->firma != '' && $p->firma != null) {
                $quelle[] = '<b>' . $p->firma . '</b>';
            }
            if ($p->abteilung != '' && $p->abteilung != null) {
                $quelle[] = $p->abteilung;
            }
            if ($p->funktion != '' && $p->funktion != null) {
                $quelle[] = $p->funktion;
            }
            if ($p->nachname != '' && $p->nachname != null) {
                $name = '';
                if ($p->vorname != '' && $p->vorname != null) {
                    $name = $p->vorname . ' ';
                }
                $quelle[] = '<b>' . $name . $p->nachname . '</b>';
            }
            if ($p->strasse != '' && $p->strasse != null) {
                $quelle[] = $p->strasse;
            }
            if ($p->ort != '' && $p->ort != null) {
                $ort = '';
                if ($p->plz != '' && $p->plz != null) {
                    $ort = $p->plz . ' ';
                }
                $quelle[] = $ort . $p->ort;
            }
            if ($p->telefon != '' && $p->telefon != null) {
                $quelle[] = $p->telefon;
            }
            if ($p->telefon2 != '' && $p->telefon2 != null) {
                $quelle[] = $p->telefon2;
            }
            if ($p->telefax != '' && $p->telefax != null) {
                $quelle[] = 'Fax: ' . $p->telefax;
            }
            if ($p->mobil != '' && $p->mobil != null) {
                $quelle[] = $p->mobil;
            }
            if ($p->emailadresse != '' && $p->emailadresse != null) {
                $quelle[] = $html->mailto($p->emailadresse);
            }
            if ($p->emailadresse2 != '' && $p->emailadresse2 != null) {
                $quelle[] = $html->mailto($p->emailadresse2);
            }
            if ($p->homepage != '' && $p->homepage != null) {
                $quelle[] = '<a href="' . FxToolsTrait::Tools_buildUrl($p->homepage) . '" target="_blank">' . $p->homepage . '</a>';
            }
        });

        $quelle = join('<br>', $quelle);
        return $quelle;
    }

    public static function getStaticLastPresse($param)
    {
        $newsarray = array();
        $datum = date('Y-m-d', mktime(0, 0, 0, (date('m') - 1), date('d'), date('Y')));
        #$datum = date('Y-m-d', mktime(0,0,0, (date('m')-1), date('d'), 2003));
        #FxToolsTrait::SQLLogger();
        $Presse = Presse::where('datum_zeit', '>=', $datum . ' 00:00:00')->where('aktiv', '=', '1')->orderBy('datum_zeit', 'DESC')->orderBy('titel', 'ASC')->take($param)->get();

        #FxToolsTrait::debug(FxToolsTrait::getSQL(), 1);

        $Presse->each(function ($n) use (&$newsarray) {
            $content = FxToolsTrait::datum_zeit($n->datum_zeit) . '<br>' . $n->titel;
            if ($n->news_kurz !== '') {
                $content .= '<br><small>' . $n->news_kurz . '</small>';
            }
            if ($n->news_lang !== '' && $n->news_lang !== '<br>' && $n->news_lang !== 'NULL' && $n->news_lang !== null) {
                $content .= '<br><a href="' . route('news') . '/' . $n->news_id . '">Weiter lesen</a>';
            }
            if ($n->news_link !== '' && $n->news_link !== '<br>' && $n->news_link !== 'NULL' && $n->news_link !== null) {
                $content .= '<br><a href="' . $n->news_link . '" target="_blank">Weiter lesen</a>';
            }
            $newsarray[] = $content;
        });
        /*
        if (count($newsarray)==0)
        {
            $newsarray[] = 'Leider sind zur Zeit keine aktuellen Presse vorhanden.';
        }
        $news='<div class="kasten1"><br><UL><li>'.join( '</li><li>', $newsarray).'</li></UL>';
        */
        if (count($newsarray) == 0) {
            return '';
        }
        $news = FxToolsTrait::build_rows($newsarray, 1);
        $content = view('widget.news_short')->with('news', $news)->render();
        return $content;
    }
}
