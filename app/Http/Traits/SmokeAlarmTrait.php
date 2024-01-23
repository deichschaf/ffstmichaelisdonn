<?php

namespace App\Http\Traits;

trait SmokeAlarmTrait
{
    private $count = 0;
    public function getNextFriday()
    {
        //Beliebiges Datum eingeben
        $startdatum = date_create('01.01.2009');
        $enddatum = date_create('31.12.2009');


        $starttag = $startdatum->format('d');
        $startmonat = $startdatum->format('m');
        $startjahr = $startdatum->format('Y');

        $endtag = $enddatum->format('d');
        $endmonat = $enddatum->format('m');
        $endjahr = $enddatum->format('Y');

        //wenn das Jahr von Anfangs- und Enddatum nicht dasselbe ist
        if($startjahr != $endjahr) {
            //für jedes Jahr
            for($jahr = $startjahr; $jahr <= $endjahr; $jahr++) {
                //wenn das Startjahr ist, soll erst beim Startmonat angefangen werden
                if($jahr == $startjahr) {
                    //vom Startmonat bis zum Ende vom Startjahr
                    for($monat = $startmonat; $monat <= 12; $monat++) {
                        //wenn der Starttag im Startmonat größer als 13 ist, soll der monat übersprungen werden
                        if($monat == $startmonat && $starttag > 13) {
                            continue;
                        } else {
                            //ansonsten wird gecheckt, ob der 13. in dem Monat ein Freitag ist
                            $counter += testthedate($monat, $jahr);
                        }
                    }
                }
                //wenn das Jahr das Endjahr ist, soll bis zum Endmonat durchgelooped werden
                elseif($jahr == $endjahr) {
                    for($monat = 1; $monat <= $endmonat; $monat++) {
                        //wenn im Endmonat der angegebene Tag kleiner als 13 ist, soll übersprungen werden
                        if($monat == $endmonat && $endtag < 13) {
                            continue;
                        } else {
                            //ansonsten wird gecheckt, ob der 13. in dem Monat ein Freitag ist
                            $counter += testthedate($monat, $jahr);
                        }
                    }
                }
                //alles dazwischen
                else {
                    for($monat = 1; $monat <= 12; $monat++) {
                        $counter += testthedate($monat, $jahr);
                    }
                }
            }
        }
        //wenn Start- und Endjahr dasselbe sind
        else {
            //für jeden Monat
            for($monat = $startmonat; $monat <= $endmonat; $monat++) {
                //wenn im Startmonat der Starttag größer als 13 ist, soll übersprungen werden
                if($monat == $startmonat && $starttag > 13) {
                    continue;
                }
                //wenn im Endmonat der Endtag kleiner als 13 ist, soll übersprungen werden
                elseif($monat == $endmonat && $endtag < 13) {
                    continue;
                }
                //alles dazwischen
                else {
                    $counter += testthedate($monat, $startjahr);
                }
            }
        }

        echo 'Summe: '.$counter;
    }
    private function testthedate($monat, $jahr)
    {
        $counter = 0;

        $test = date_create('13.' . $monat . '.' . $jahr);
        $testdatum = $test->format('d.m.Y');
        $testtag = date('l', mktime(0, 0, 0, $monat, 13, $jahr));
        //wenn der 13. des Monats ein Freitag ist, soll er ausgegeben werden und hochgezählt
        if ($testtag == 'Friday') {
            echo $testdatum . '<br/>';
            $counter++;
        }
        return $counter;
    }
}
