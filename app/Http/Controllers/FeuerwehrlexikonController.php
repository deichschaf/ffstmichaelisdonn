<?php

namespace App\Http\Controllers;

use App\Http\Models\Feuerwehrlexikon;

class FeuerwehrlexikonController extends GroundController
{
    public function lexikon_show($show = false)
    {
        $lexikon = [];
    }

    private function search($show)
    {
        if (preg_match('/[a-zA-Z]/', $show)) {
            $show = ucfirst($show);
        } else {
            $show = 'A';
        }

        if (strlen($show) > 1 || $show === false) {
            $show = 'A';
        }
        //        elseif(){
        //
        //        }
        else {
            $show = 'A';
        }

        $keyword = $show;
        $aktiv = $show;
        $show2 = '';
        if ($show == 'A') {
            $show2 = 'Ä';
        } elseif ($show === 'O') {
            $show2 = 'Ö';
        } elseif ($show === 'U') {
            $show2 === 'Ü';
        }
    }

    private function buildLexikon($aktiv)
    {
        $links = [];
        $abc = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        ];
        $c = count($abc);
        $i = 0;
        foreach ($abc as $k => $v) {
            $class = '';
            if ($aktiv == $v) {
                $class = ' aktiv';
            }
            $links[] = '<a href="/index.php?page=' . $page . '&show=' . $v . '&" class="lexikonlink' . $class . '">' . $v . '</a>';
        }
    }

    private function getLex()
    {
        $tx = '<tr class="bg_ueberschrift">';
        $tx .= '<td>';

        $tx .= '</td>';
        $tx .= '</tr>';

        $sql = "SELECT * FROM " . CMS_TABLE_SUFIX . "cms_lexikon_keywords AS kl
				LEFT JOIN
					" . CMS_TABLE_SUFIX . "cms_lexikon AS l
				ON l.lexikon_id=kl.lexikon_id
				WHERE
					keyword LIKE '" . $keyword . "%'";
        $query = $mysql->Query($sql) or die(mysql_error());
        while ($row = mysql_fetch_assoc($query)) {
            $lexikon[] = array('eintrag' => $row['keyword'], 'beschreibung' => $row['beschreibung']);
        }

        $sql = "SELECT * FROM " . CMS_TABLE_SUFIX . "cms_lexikon
				WHERE
					eintrag LIKE '" . $show . "%'
				ORDER BY
					eintrag ASC";
        $query = $mysql->Query($sql) or die(mysql_error());
        while ($row = mysql_fetch_assoc($query)) {
            $lexikon[] = array('eintrag' => $row['eintrag'], 'beschreibung' => $row['beschreibung']);
        }
        asort($lexikon);
        $kat = '';
        $class = 'bgdunkel';
        foreach ($lexikon as $key => $row) {
            if ($class == 'bgdunkel') {
                $class = 'bghell';
            } else {
                $class = 'bgdunkel';
            }
            $tx .= '<tr class="' . $class . '">';
            $tx .= '<td><b>' . $row['eintrag'] . '</b>';
            if ($row['beschreibung'] != '') {
                $tx .= '<br>' . $row['beschreibung'];
            }
            $tx .= '</td>';
            $tx .= '</tr>';
        }
        $tx .= '</table>';
        echo $tx;
    }
}
