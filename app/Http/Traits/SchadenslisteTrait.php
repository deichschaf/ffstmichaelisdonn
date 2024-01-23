<?php

namespace App\Http\Traits;

use App\Http\Models\Schadensliste;
use App\Http\Models\SchadenslisteEG;
use App\Http\Models\SchadenslisteEMK;
use App\Http\Models\SchadenslisteEW;
use App\Http\Models\SchadenslisteGSA;
use App\Http\Models\SchadenslisteRettung;
use App\Http\Models\TELLexikonFAQ;
use App\Http\Traits\FxToolsTrait;

trait SchadenslisteTrait
{
    public static function gsa()
    {
        $data = array();
        $data['0'] = '---';
        $GSA = SchadenslisteGSA::orderBy('gsa', 'ASC')->get();
        $GSA->each(function ($g) use (&$data) {
            $data[$g->id] = $g->gsa;
        });
        return $data;
    }

    public static function eg()
    {
        $data = array();
        $data['0'] = '---';
        $EG = SchadenslisteEG::orderBy('eg', 'ASC')->get();
        $EG->each(function ($e) use (&$data) {
            $data[$e->id] = $e->eg;
        });
        return $data;
    }
    public static function emk()
    {
        $data = array();
        $data['0'] = '---';
        $EMK = SchadenslisteEMK::orderBy('emk', 'ASC')->get();
        $EMK->each(function ($e) use (&$data) {
            $data[$e->id] = $e->emk;
        });
        return $data;
    }
    public static function ew()
    {
        $data = array();
        $data['0'] = '---';
        $EW = SchadenslisteEW::orderBy('ew', 'ASC')->get();
        $EW->each(function ($e) use (&$data) {
            $data[$e->id] = $e->ew;
        });
        return $data;
    }
    public static function rettungsdienst()
    {
        $data = array();
        $data['0'] = '';
        $RD = SchadenslisteRettung::orderBy('rettungsdienst', 'ASC')->get();
        $RD->each(function ($r) use (&$data) {
            $data[$r->id] = $r->rettungsdienst;
        });
        return $data;
    }

    public static function SaveSchaden($data)
    {
    }

    public static function getStaticSchaden($gsa, $ew, $eg)
    {
        $data_gsa = SchadenslisteTrait::gsa();
        $data_rettungsdienst = SchadenslisteTrait::rettungsdienst();
        $data_eg = SchadenslisteTrait::eg();
        $data_emk = SchadenslisteTrait::emk();
        $data_ew = SchadenslisteTrait::ew();
        $data = array();
        $Schaden = Schadensliste::where('gsa_id', '=', $gsa)->where('ew_id', '=', $ew)->where('eg_id', '=', $eg)->get();
        $Schaden->each(function ($s) use (&$data, $gsa, $eg, $ew, $data_eg, $data_emk, $data_ew, $data_gsa, $data_rettungsdienst) {
            $einsatzstichwort = array();
            if ($gsa != 0) {
                $einsatzstichwort[] = $data_gsa[$gsa];
            }
            if ($eg != 0) {
                $einsatzstichwort[] = $data_eg[$eg];
            }
            if ($ew != 0) {
                $einsatzstichwort[] = $data_ew[$ew];
            }
            $data[] = array('headline' => 'Stichwort', 'text' => join(' ', $einsatzstichwort));
            $data[] = array('headline' => SchadenslisteTrait::lex('Bezeichung'), 'text' => $s->bezeichnung);
            $data[] = array('headline' => SchadenslisteTrait::lex('Beschreibung'), 'text' => $s->beschreibung);
            $data[] = array('headline' => SchadenslisteTrait::lex('Beschreibung wichtig'), 'text' => $s->beschreibung_wichtig);
            $data[] = array('headline' => SchadenslisteTrait::lex('Beispiele'), 'text' => $s->beschreibung_beispiele);
            $data[] = array('headline' => SchadenslisteTrait::lex('Klasse'), 'text' => $s->klasse);
            $data[] = array('headline' => SchadenslisteTrait::lex('Stamm'), 'text' => $s->stamm);
            $data[] = array('headline' => SchadenslisteTrait::lex('Filer'), 'text' => $s->filter);
            $data[] = array('headline' => SchadenslisteTrait::lex('Basis'), 'text' => $s->basis);
            $data[] = array('headline' => SchadenslisteTrait::lex('Risikostufe'), 'text' => $s->risikostufe);
            $data[] = array('headline' => SchadenslisteTrait::lex('GGW'), 'text' => $s->ggw);
            $data[] = array('headline' => SchadenslisteTrait::lex('St&auml;rke'), 'text' => $s->staerke);
            $data[] = array('headline' => SchadenslisteTrait::lex('ASG'), 'text' => $s->asg);
            $data[] = array('headline' => SchadenslisteTrait::lex('ASGTR'), 'text' => $s->asgtr);
            $data[] = array('headline' => SchadenslisteTrait::lex('L&ouml;schmittel'), 'text' => $s->lm);
            $data[] = array('headline' => SchadenslisteTrait::lex('L&ouml;schmittel LZ-G'), 'text' => $s->lmlzg);
            $data[] = array('headline' => SchadenslisteTrait::lex('Schauml&ouml;schmittel'), 'text' => $s->slm);
            $data[] = array('headline' => SchadenslisteTrait::lex('RSB'), 'text' => $s->rsb);
            $data[] = array('headline' => SchadenslisteTrait::lex('EMK'), 'text' => $s->emk);
            $data[] = array('headline' => SchadenslisteTrait::lex('DL'), 'text' => $s->dl);
            $data[] = array('headline' => SchadenslisteTrait::lex('HRS'), 'text' => $s->hrs);

            $rd = '';
            if (array_key_exists($s->tel_schadensliste_rettungsdienst_id, $data_rettungsdienst)) {
                $rd = $data_rettungsdienst[$s->tel_schadensliste_rettungsdienst_id];
            }

            $data[] = array('headline' => SchadenslisteTrait::lex('Rettungsdienst'), 'text' => $rd);
            $data[] = array('headline' => SchadenslisteTrait::lex('EPS'), 'text' => SchadenslisteTrait::lex($s->eps));
            $data[] = array('headline' => SchadenslisteTrait::lex('THW'), 'text' => $s->thw);
            $data[] = array('headline' => SchadenslisteTrait::lex('Sonstiges'), 'text' => $s->sonstiges);
        });

        return $data;
    }

    public static function getStaticTELBegriffe()
    {
        $data = array();
        $LEX = TELLexikonFAQ::get();
        $LEX->each(function ($f) use (&$data) {
            $data[$f->eintrag] = $f->beschreibung;
        });
        return $data;
    }

    private static function lex($word)
    {
        $texte = SchadenslisteTrait::getTELBegriffe();
        $word = trim($word);
        $words = explode(' ', $word);
        $tx = '';
        foreach ($words as $key => $word) {
            if ($tx != '') {
                $tx .= " ";
            }
            if (array_key_exists(strtolower($word), $texte)) {
                $tx .= FxToolsTrait::build_tolltip($word, $texte[strtolower($word)]);
            } else {
                $tx .= $word;
            }
        }
        return $tx;
    }
}
