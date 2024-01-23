<?php

namespace App\Http\Traits;

use App\Http\Models\Newsletter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait NewsletterTrait
{
    public static function getStaticAllNewsletter()
    {
        $newsletter = [];
        $Newsletter = Newsletter::where('active', '=', '1')->orderBy('newsletter_datum', 'DESC')->get();
        $Newsletter->each(function ($n) use (&$newsletter) {
            $newsletter[] = [
                'id' => $n->id,
                'newsletter_datum' => FxToolsTrait::datum_de_static($n->newsletter_datum),
                'newsletter_titel' => $n->newsletter_titel,
                'versendet_an' => $n->versendet_an,
                'datei' => $n->datei,
                'datei_titel' => $n->datei_titel,
                'datei2' => $n->datei2,
                'datei2_titel' => $n->datei2_titel,
                'datei3' => $n->datei3,
                'datei3_titel' => $n->datei3_titel,
                'datei4' => $n->datei4,
                'datei4_titel' => $n->datei4_titel,
                'zustellbestaetigung' => $n->zustellbestaetigung,
                'empfangsbestaetigung' => $n->empfangsbestaetigung,
                'lesebestaetigung' => $n->lesebestaetigung,
            ];
        });
        return $newsletter;
    }
}
