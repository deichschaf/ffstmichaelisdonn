<?php

namespace App\Http\Traits;

use Anouar\Fpdf\Facades\Fpdf;
use App\Http\Models\Funkrufnamen;
use App\Http\Controllers\PDF;
use App\Http\Traits\HiOrgsTrait;
use Illuminate\Support\Facades\DB;

trait PDFFunkrufnamenGemeindenTrait
{
    public static function getStaticConfig()
    {
        $config = array();
        $config ['pdf_funk'] = 45;
        $config ['pdf_ort'] = 60;
        $config ['pdf_art'] = 30;
        $config ['links'] = 15;
        $config ['pdf_links'] = 40;
        $config ['pdf_haupt'] = 155;
        $config ['pdf_spalte'] = 60; // 48.75;
        $config ['pdf_spalte1'] = 30;
        $config ['pdf_spalte2'] = 15;
        $config ['pdf_spalte3'] = 110;
        $config ['pdf_spalte4'] = 40;
        $config ['pdf_zeile'] = $config ['pdf_funk'] + $config ['pdf_ort'] + $config['pdf_art'];
        $config ['pdf_hoehe'] = 4;
        $config ['pdf_max'] = 82;
        $config ['pdf_font'] = 'Arial';
        $config ['font_size_ueberschrift'] = 14;
        $config ['font_size_ueberschrift1'] = 10;
        $config ['font_size_ueberschrift2'] = 7;
        $config ['font_size_normal'] = 8;
        $config ['font_size_klein'] = 6;
        $config ['pdf_color'] = "0,0,0";
        $config ['pdf_color_ueberschrift'] = "214";
        return $config;
    }

    private static function makeAddHead($pdf, $config = array())
    {
        $config = PDFFunkrufnamenGemeindenTrait::getConfig();
        $pdf->AddPage();
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], $pdf->UTF8Text(TITEL), 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift1']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], $pdf->UTF8Text('Funkrufnamen nach Ämtern'), 0, 1, 'C');
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->Rect(10, 5, 195, 22);
        $pdf->SetDrawColor(0);
        $pdf->SetY(30);
        return $pdf;
    }

    private static function getHiOrgs($pdf)
    {
        $config = PDFFunkrufnamenGemeindenTrait::getConfig();
        $HiOrgs = HiOrgsTrait::getHiOrgs();
        foreach ($HiOrgs as $key => $o) {
            $pdf->SetX($config['pdf_links']);
            $pdf->Cell($config['pdf_funk'], $config['pdf_hoehe'], $pdf->UTF8Text(strtoupper($key)), 0, 0);
            $pdf->Cell(($config['pdf_ort'] + $config['pdf_art']), $config['pdf_hoehe'], $pdf->UTF8Text($o), 0, 1);
        }
        return $pdf;
    }

    private static function getRufnamen($pdf)
    {
        $config = PDFFunkrufnamenGemeindenTrait::getConfig();
        $HiOrgs = HiOrgsTrait::getHiOrgs();
        $pdf->SetFont($config['pdf_font'], '', $config['font_size_normal']);
        $y = 0;
        $y2 = 0;
        $getY = $pdf->GetY();
        foreach ($HiOrgs as $key => $HiOrg) {
            $amt = '';
            $Funk = Funkrufnamen::where($key, '=', '1')
                        ->where('kreis', '=', 'Dithmarschen')
                        ->orderBy(DB::raw('ABS(`wache`)'), 'ASC')
                        ->orderBy(DB::raw('ABS(`gruppe`)'), 'ASC')
                        ->orderBy(DB::raw('ABS(`nr`)'), 'ASC')
                        ->get();
            $Funk->each(function ($f) use (&$pdf, $config, &$y, &$y2, &$key, &$HiOrg, &$getY, &$amt) {
                if ($y2 === 3) {
                    $pdf->AddPage();
                    $pdf->SetFont($config['pdf_font'], 'B', $config['font_size_ueberschrift']);
                    $pdf->Cell($config['pdf_zeile'], $config['pdf_hoehe'], $pdf->UTF8Text('Funkrufnamen'), 0, 1, 'C');
                    $pdf->SetY(25);
                    $getY = $pdf->GetY();
                    $links = 10;
                    $y2 = 0;
                    $pdf->SetFont($config['pdf_font'], '', $config['font_size_normal']);
                }
                $pdf->SetX($config['pdf_links']);
                $funk = array();
                if ($f->wache !== '') {
                    $funk [] = $f->wache;
                }
                if ($f->gruppe !== '') {
                    $funk [] = $f->gruppe;
                }
                if ($f->nr !== '') {
                    $funk [] = $f->nr;
                }
                if (count($funk) > 0) {
                    $funk = join('-', $funk);
                    if ($funk !== '') {
                        $funk = ' ' . $funk;
                    }
                } else {
                    $funk = '';
                }

                if ($amt !== $f->amt) {
                    if ($amt !== '') {
                        $pdf->Ln();
                    }
                    $amt = $f->amt;
                    $pdf->SetX($config['links']);
                    $pdf->SetFont($config['pdf_font'], 'B', $config['font_size_ueberschrift']);
                    $pdf->Cell($config['pdf_zeile'], $config['pdf_hoehe'], $pdf->UTF8Text($amt), 0, 1);
                }
                $pdf->SetFont($config['pdf_font'], '', $config['font_size_normal']);
                $pdf->SetX($config['links']);
                $pdf->Cell($config['pdf_funk'], $config['pdf_hoehe'], $pdf->UTF8Text($HiOrg . ' ' . $funk), 0, 0);
                $pdf->Cell($config['pdf_funk'], $config['pdf_hoehe'], $pdf->UTF8Text($f->ort), 0, 0);
                $pdf->Cell($config['pdf_funk'], $config['pdf_hoehe'], $pdf->UTF8Text($f->art), 0, 1);
            });
        }
        return $pdf;
    }

    private static function getFunkrufnamen($pdf)
    {
        $config = PDFFunkrufnamenGemeindenTrait::getConfig();
        $pdf = PDFFunkrufnamenGemeindenTrait::makeAddHead($pdf, $config);
        $pdf = PDFFunkrufnamenGemeindenTrait::getRufnamen($pdf);
        $pdf = PDFFunkrufnamenGemeindenTrait::getHiOrgs($pdf);
        return $pdf;
    }

    /**
     * Beginne jetzt die PDF Erstellung
     */
    public static function getStaticPdf($file)
    {
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->SetAuthor(PDFAUTOR);
        $pdf = PDFFunkrufnamenGemeindenTrait::getFunkrufnamen($pdf);

        // PDF Output
        if ($file === "pdf") {
            $pdf->Output('Funkrufnamen_Gemeinden.pdf', 'D'); // Dokument wird an den Browser geschickt
        } else {
            $pdf->Output('Funkrufnamen_Gemeinden.pdf', 'I'); // Dokument wird an den Browser geschickt
        }
    }
}
