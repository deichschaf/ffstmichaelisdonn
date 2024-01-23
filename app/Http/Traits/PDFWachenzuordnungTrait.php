<?php

namespace App\Http\Traits;

use Anouar\Fpdf\Facades\Fpdf;
use App\Http\Models\Funkrufnamen;
use App\Http\Controllers\PDF;
use App\Http\Traits\HiOrgsTrait;
use Illuminate\Support\Facades\DB;

trait PDFWachenzuordnungTrait
{
    private static function getConfig()
    {
        $font_size_normal = 5;
        $font_size_klein = 6;
        $pdf_color = "0,0,0";
        $pdf_color_ueberschrift = "214";


        $config = array();
        $config ['pdf_funk'] = 10;
        $config ['pdf_ort'] = 28;
        $config ['pdf_art'] = 20;
        $config ['links'] = 15;
        $config ['pdf_links'] = 40;
        $config ['pdf_haupt'] = 155;
        $config ['pdf_spalte'] = 60; // 48.75;
        $config ['pdf_spalte1'] = 30;
        $config ['pdf_spalte2'] = 15;
        $config ['pdf_spalte3'] = 110;
        $config ['pdf_spalte4'] = 40;
        $config ['pdf_zeile'] = $config ['pdf_funk'] + $config ['pdf_ort'] + $config['pdf_art'];
        $config ['pdf_hoehe'] = 3;
        $config ['pdf_max'] = 82;
        $config ['pdf_font'] = 'Arial';
        $config ['font_size_ueberschrift'] = 14;
        $config ['font_size_ueberschrift1'] = 10;
        $config ['font_size_ueberschrift2'] = 7;
        $config ['font_size_normal'] = 5;
        $config ['font_size_klein'] = 6;
        $config ['pdf_color'] = "0,0,0";
        $config ['pdf_color_ueberschrift'] = "214";
        return $config;
    }

    private static function makeAddHead($pdf, $config = array())
    {
        $config = PDFWachenzuordnungTrait::getConfig();
        $pdf->AddPage();
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], $pdf->UTF8Text(TITEL), 0, 1, 'C');
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift1']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], 'Funkrufnamen', 0, 1, 'C');
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->Rect(10, 5, 195, 22);
        $pdf->SetDrawColor(0);
        $pdf->SetY(25);
        return $pdf;
    }

    private static function getHiOrgs($pdf)
    {
        $config = PDFWachenzuordnungTrait::getConfig();
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
        $config = PDFWachenzuordnungTrait::getConfig();
        $HiOrgs = HiOrgsTrait::getHiOrgs();
        $pdf->SetFont($config['pdf_font'], '', $config['font_size_normal']);
        $y = 0;
        $y2 = 0;
        $getY = $pdf->GetY();
        foreach ($HiOrgs as $key => $o) {
            $Funk = Funkrufnamen::where($key, '=', '1')
                        ->orderBy(DB::raw('ABS(`wache`)'), 'ASC')
                        ->orderBy(DB::raw('ABS(`gruppe`)'), 'ASC')
                        ->orderBy(DB::raw('ABS(`nr`)'), 'ASC')
                        ->get();
            $Funk->each(function ($f) use (&$pdf, $config, &$y, &$y2, &$key, &$getY) {
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
                $pdf->Cell($config['pdf_funk'], $config['pdf_hoehe'], $pdf->UTF8Text(strtoupper($key) . $funk), 0, 0);
                $pdf->Cell($config['pdf_ort'], $config['pdf_hoehe'], $pdf->UTF8Text($f->ort), 0, 0);
                $pdf->Cell($config['pdf_art'], $config['pdf_hoehe'], $pdf->UTF8Text($f->art), 0, 1);

                $y++;

                // if ($y>64)
                if ($y > $config['pdf_max']) {
                    $y = 0;
                    $y2++;
                    $links = $config['links'] + $config['pdf_zeile'];
                    $get = $pdf->GetY();

                    $pdf->SetDrawColor(0, 0, 0);
                    $pdf->SetLineWidth(0.1);
                    if ($y2 !== 3) {
                        $pdf->Line(($links - 1), $getY, ($links - 1), $get);
                    }
                    $pdf->SetY($getY);
                }
            });
        }
        return $pdf;
    }

    private static function getFunkrufnamen($pdf)
    {
        $config = PDFWachenzuordnungTrait::getConfig();
        $pdf = PDFWachenzuordnungTrait::makeAddHead($pdf, $config);
        $pdf = PDFWachenzuordnungTrait::getRufnamen($pdf);
        $pdf = PDFWachenzuordnungTrait::getHiOrgs($pdf);
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
        $pdf = PDFWachenzuordnungTrait::getFunkrufnamen($pdf);

        // PDF Output
        if ($file === "pdf") {
            $pdf->Output('Funkrufnamen.pdf', 'D'); // Dokument wird an den Browser geschickt
        } else {
            $pdf->Output('Funkrufnamen.pdf', 'I'); // Dokument wird an den Browser geschickt
        }
    }
}
