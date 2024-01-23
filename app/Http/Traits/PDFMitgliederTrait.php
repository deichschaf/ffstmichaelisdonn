<?php

namespace App\Http\Traits;

use Anouar\Fpdf\Facades\Fpdf;
use App\Http\Models\Mitglieder;
use App\Http\Controllers\PDF;

trait PDFMitgliederTrait
{
    private static function getConfig()
    {
        $config = array();
        $config ['pdf_links'] = 40;
        $config ['pdf_haupt'] = 155;
        $config ['pdf_spalte'] = 60; // 48.75;
        $config ['pdf_zeile'] = $config ['pdf_links'] + $config ['pdf_haupt'];
        $config ['pdf_hoehe'] = 4;
        $config ['pdf_font'] = 'Arial';
        $config ['font_size_ueberschrift'] = 14;
        $config ['font_size_ueberschrift1'] = 10;
        $config ['font_size_ueberschrift2'] = 7;
        $config ['font_size_normal'] = 8;
        $config ['pdf_color'] = "0,0,0";
        $config ['pdf_color_ueberschrift'] = "214";
        return $config;
    }

    private static function makeAddHead($pdf, $config = array(), $aktiv)
    {
        $pdf->AddPage();
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], TITEL, 0, 1, 'C');
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift1']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], $pdf->UTF8Text('Telefonliste'), 0, 1, 'C');
        $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_ueberschrift2']);
        $pdf->Cell($config ['pdf_zeile'], $config ['pdf_hoehe'], $pdf->UTF8Text($aktiv), 0, 1, 'C');
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->Rect(10, 5, 195, 22);
        $pdf->SetDrawColor(0);
        $pdf->Ln();
        $pdf->Ln();
        return $pdf;
    }

    private static function buildRows($row)
    {
        $rows = array();
        $spalte1 = $row ['nachname'] . ', ' . $row ['vorname'];
        $spalte2 = $row ['strasse'];
        $spalte3 = $row ['plz'] . ' ' . $row ['ort'];
        $spalte4 = '';
        $rows [] = array(
            $spalte1,
            $spalte2,
            $spalte3,
            $spalte4
        );
        if ($row ['sichtbar_email'] === '1') {
            if ($row ['emailadresse'] !== '' && $row ['emailadresse'] !== null) {
                $spalte1 = 'E-Mail:';
                $spalte2 = $row ['emailadresse'];
                $spalte3 = '';
                $spalte4 = '';
                $rows [] = array(
                    $spalte1,
                    $spalte2,
                    $spalte3,
                    $spalte4
                );
            }
        }
        if ($row ['sichtbar_email2'] === '1') {
            if ($row ['emailadresse2'] !== '' && $row ['emailadresse2'] !== null) {
                $spalte1 = 'E-Mail:';
                $spalte2 = $row ['emailadresse2'];
                $spalte3 = '';
                $spalte4 = '';
                $rows [] = array(
                    $spalte1,
                    $spalte2,
                    $spalte3,
                    $spalte4
                );
            }
        }
        if ($row ['sichtbar_telefon'] === '1') {
            if ($row ['telefon'] !== '' && $row ['telefon'] !== null) {
                $spalte1 = 'Telefon privat:';
                $spalte2 = $row ['telefon'];
                $spalte3 = '';
                $spalte4 = '';
                $rows [] = array(
                    $spalte1,
                    $spalte2,
                    $spalte3,
                    $spalte4
                );
            }
        }
        if ($row ['sichtbar_telefon2'] === '1') {
            if ($row ['telefon2'] !== '' && $row ['telefon2'] !== null) {
                $spalte1 = 'Telefon:';
                $spalte2 = $row ['telefon2'];
                $spalte3 = '';
                $spalte4 = '';
                $rows [] = array(
                    $spalte1,
                    $spalte2,
                    $spalte3,
                    $spalte4
                );
            }
        }
        if ($row ['sichtbar_dienstlich'] === '1') {
            if ($row ['dienstlich'] !== '' && $row ['dienstlich'] !== null) {
                $spalte1 = 'dienstlich:';
                $spalte2 = $row ['dienstlich'];
                $spalte3 = '';
                $spalte4 = '';
                $rows [] = array(
                    $spalte1,
                    $spalte2,
                    $spalte3,
                    $spalte4
                );
            }
        }
        if ($row ['sichtbar_mobil'] === '1') {
            if ($row ['mobil'] !== '' && $row ['mobil'] !== null) {
                $spalte1 = 'Mobil:';
                $spalte2 = $row ['mobil'];
                $spalte3 = '';
                $spalte4 = '';
                $rows [] = array(
                    $spalte1,
                    $spalte2,
                    $spalte3,
                    $spalte4
                );
            }
        }
        return $rows;
    }

    private static function getMitglieder($pdf, $altgedienter = 0, $sichtbar = 1)
    {
        $config = PDFMitgliederTrait::getConfig();
        $i = 0;
        $Mitglieder = Mitglieder::where('altgedienter', '=', $altgedienter)
                        ->where('ausgeschieden', '=', '0')
                        ->where('sichtbar', '=', $sichtbar)
                        ->where('deaktiv', '=', '0')
                        ->orderBy('nachname', 'ASC')
                        ->orderBy('vorname', 'ASC')
                        ->orderBy('ort', 'ASC')
                        ->orderBy('strasse', 'ASC')
                        ->get();
        $Mitglieder->each(function ($row) use (&$pdf, &$config, &$i, &$altgedienter) {
            $pdf->SetFillColor(255, 255, 255);
            $pos = $pdf->GetY();

            if ($altgedienter === '0') {
                $t = 'Aktiver Dienst';
            } else {
                $t = 'Ehrenmitglieder';
            }
            if ($pos >= 265 || $i === 0) {
                PDFMitgliederTrait::makeAddHead($pdf, $config, $t);
                $i = 1;
            }
            $pdf->SetFont($config ['pdf_font'], '', $config ['font_size_normal']);
            $pdf->SetWidths(array(
                $config ['pdf_spalte'],
                $config ['pdf_spalte'],
                $config ['pdf_spalte'],
                $config ['pdf_spalte']
            ));
            $rows = PDFMitgliederTrait::buildRows($row);
            $count = count($rows);
            if ($count > 1) {
                $high = $config ['font_size_normal'] * $count;
                if (($high + $pos) >= 274) {
                    PDFMitgliederTrait::makeAddHead($pdf, $config, $t);
                    $i = 1;
                }
            }
            foreach ($rows as $key => $value) {
                if ($key === 0) {
                    $pdf->SetTextColor($config ['pdf_color']);
                    $pdf->SetFont($config ['pdf_font'], 'B', $config ['font_size_normal']);
                    $pdf->SetFillColor(200);
                } else {
                    $pdf->SetFillColor(255);
                    $pdf->SetFont($config ['pdf_font'], '', $config ['font_size_normal']);
                }
                $pdf->Row(array(
                    $pdf->UTF8Text($value ['0']),
                    $pdf->UTF8Text($value ['1']),
                    $pdf->UTF8Text($value ['2']),
                    $pdf->UTF8Text($value ['3'])
                ));
            }
        });
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
        PDFMitgliederTrait::getMitglieder($pdf, 0, 1);
        PDFMitgliederTrait::getMitglieder($pdf, 1, 1);
        // PDF Output
        if ($file === "pdf") {
            $pdf->Output('Mitglieder.pdf', 'D'); // Dokument wird an den Browser geschickt
        } else {
            $pdf->Output('Mitglieder.pdf', 'I'); // Dokument wird an den Browser geschickt
        }
    }
}
