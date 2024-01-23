<?php

namespace App\Http\Traits;

use Anouar\Fpdf\Facades\Fpdf;
use App\Http\Models\Termine;
use App\Http\Models\Texte;
use App\Http\Controllers\PDF;

trait PDFDienstplanTrait
{
    private static function getConfig()
    {
        $config = array();
        $config ['pdf_links'] = 40;
        $config ['pdf_haupt'] = 155;
        $config ['pdf_spalte'] = 60; // 48.75;
        $config ['pdf_spalte1'] = 30;
        $config ['pdf_spalte2'] = 15;
        $config ['pdf_spalte3'] = 110;
        $config ['pdf_spalte4'] = 40;
        $config ['pdf_zeile'] = $config ['pdf_links'] + $config ['pdf_haupt'];
        $config ['pdf_hoehe'] = 4;
        $config ['pdf_font'] = 'Arial';
        $config ['font_size_ueberschrift'] = 14;
        $config ['font_size_ueberschrift1'] = 10;
        $config ['font_size_ueberschrift2'] = 7;
        $config ['font_size_normal'] = 10;
        $config ['font_size_klein'] = 6;
        $config ['pdf_color'] = "0,0,0";
        $config ['pdf_color_red'] = "255,0,0";
        $config ['pdf_color_ueberschrift'] = "214";
        return $config;
    }

    private static function makeAddHead($pdf, $config = array())
    {
        $config = PDFDienstplanTrait::getConfig();
        $pdf->AddPage();
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], $pdf->UTF8Text(TITEL), 0, 1, 'C');
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift1']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], 'Dienstplan', 0, 1, 'C');
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->Rect(10, 5, 195, 22);
        $pdf->SetDrawColor(0);
        $pdf->SetY(30);
        return $pdf;
    }

    private static function getText($area, $pdf)
    {
        $config = PDFDienstplanTrait::getConfig();
        $text = '';
        $Texte = Texte::where('text_titel', '=', $area)->get();
        $Texte->each(function ($t) use (&$text) {
            $text = $t->text;
        });
        $pdf->SetFont($config['pdf_font'], '', $config['font_size_normal']);
        $pdf->MultiCell($config['pdf_zeile'], $config['pdf_hoehe'], $pdf->UTF8Text($text), 0);
        $pdf->Ln();
        return $pdf;
    }

    private static function getDienstplanContent($pdf)
    {
        $config = PDFDienstplanTrait::getConfig();
        $kleidungen = array(
            'ausgehuniform' => 'A',
            'dienstanzug' => 'D',
            'freizeit' => 'F'
        );
        $class = 1;
        $Termine = Termine::where('datum', '>=', date('Y') . "-01-01")
                    ->orderBy('datum', 'ASC')
                    ->orderBy('beginn', 'ASC')
                    ->orderBy('termin', 'ASC')
                    ->get();
        $i = 0;
        $Termine->each(function ($row) use (&$pdf, $kleidungen, &$i, $config) {
            $pdf->SetDrawColor(0, 0, 0);
            if ($i === 30) {
                $i = 0;
                $pdf = PDFDienstplanTrait::makeAddHead($pdf, $config);
                $pdf->SetY(30);
            }
            $pdf->SetFont($config['pdf_font'], '', $config['font_size_normal']);
            $i++;
            $pdf->SetWidths(array(
                $config['pdf_spalte1'],
                $config['pdf_spalte2'],
                $config['pdf_spalte3'],
                $config['pdf_spalte4']
            ));
            $pdf->SetTextColor($config['pdf_color']);
            if ($row ['datum'] !== '' && $row ['datum'] !== null) {
                $datum = FxToolsTrait::datum_de_static($row ['datum']);
                $datum = FxToolsTrait::Wochentag($datum) . ', ' . $datum;
            }

            if ($row ['datum_bis'] !== '' && $row ['datum_bis'] !== null && $row ['datum'] !== $row ['datum_bis']) {
                $datum .= ' - ';
                $datum_bis = FxToolsTrait::datum_de_static($row ['datum_bis']);
                $datum .= FxToolsTrait::Wochentag($datum_bis) . ', ' . $datum_bis;
            }
            $zeit = '';
            $bis = '';
            if ($row ['beginn'] !== '' && $row ['beginn'] !== null && $row ['beginn'] !== '55:55:55') {
                $zeit = FxToolsTrait::zeit_static($row ['beginn']);
            }
            if ($row ['bis'] !== '' && $row ['bis'] !== null && $row ['bis'] !== '55:55:55') {
                $zeit .= ' - ' . FxToolsTrait::zeit_static($row ['bis']);
            }
            $abfahrt = '';
            if ($row ['abfahrt'] !== '' && $row ['abfahrt'] !== null && $row ['abfahrt'] !== '55:55:55') {
                $abfahrt = FxToolsTrait::zeit_static($row ['abfahrt']);
            }
            $termin = $row ['termin'];
            $ort = $row ['veranstaltungsort'];
            $kleidung = $kleidungen [$row ['kleidung']];

            $spalte1 = $pdf->UTF8Text($datum);
            $spalte2 = $zeit;
            $spalte3 = $pdf->UTF8Text($termin);
            $spalte4 = $pdf->UTF8Text($ort);
            if ($row ['pflicht'] === '1') {
                $pdf->SetFont($config['pdf_font'], 'B', $config['font_size_normal']);
            } else {
                $pdf->SetFont($config['pdf_font'], '', $config['font_size_normal']);
            }
            if ($i === 0 || $i === 1) {
                $border = 0;
            } else {
                $border = 'T';
            }
            $pdf->Row(array(
                $spalte1,
                $spalte2,
                $spalte3,
                $spalte4
            ), $border);
            // $pdf->SetFillColor(255);

            if ($row ['beschreibung'] !== '' && $row ['beschreibung'] !== null) {
                $pdf->SetFont($config['pdf_font'], '', $config['font_size_klein']);
                $spalte1 = '';
                $spalte2 = '';
                $spalte3 = $pdf->UTF8Text($row ['beschreibung']);
                $spalte4 = '';
                $pdf->Row(array(
                    $spalte1,
                    $spalte2,
                    $spalte3,
                    $spalte4
                ));
            }

            if ($row ['ausgefallen_grund'] !== '' && $row ['ausgefallen_grund'] !== null) {
                $pdf->SetFont($config['pdf_font'], '', $config['font_size_klein']);
                $spalte1 = '';
                $spalte2 = '';
                $spalte3 = $pdf->UTF8Text($row ['ausgefallen_grund']);
                $spalte4 = '';

                $pdf->SetTextColor(255, 0, 0);
                $pdf->Row(array(
                    $spalte1,
                    $spalte2,
                    $spalte3,
                    $spalte4
                ));
            }
        });
        return $pdf;
    }

    private static function getDienstplan($pdf)
    {
        $config = PDFDienstplanTrait::getConfig();
        $pdf = PDFDienstplanTrait::makeAddHead($pdf, $config);
        $pdf = PDFDienstplanTrait::getText('pdf_dienstplan_text1', $pdf);
        $pdf = PDFDienstplanTrait::getDienstplanContent($pdf);
        $pdf = PDFDienstplanTrait::getText('pdf_dienstplan_text2', $pdf);

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
        $pdf = PDFDienstplanTrait::getDienstplan($pdf);

        // PDF Output
        if ($file === "pdf") {
            $pdf->Output('Dienstplan.pdf', 'D'); // Dokument wird an den Browser geschickt
        } else {
            $pdf->Output('Dienstplan.pdf', 'I'); // Dokument wird an den Browser geschickt
        }
    }
}
