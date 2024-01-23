<?PHP
require_once("../lib/init.php");
$tools=new Tools();
define('DATE_ICAL', 'Ymd\THis\Z');

function get_right_text($txt)
{
	$txt=trim($txt);
	$txt=utf8_encode($txt);
	return $txt;
}

function icaldate($date, $time)
{
  $str='';
  $date=explode('-', $date);
  $date=join('',$date);
  if ($time!='55:55:55')
  {
    $time=explode(':',$time);
    $time=join('', $time);
  }
  else
  {
    $time='000000';
  }
  $str=$date.'T'.$time; //.'Z';
  return $str;
}

$output = "BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
PRODID:-//Feuerwehr Sankt Michaelisdonn//DE\n";

$sql="SELECT * FROM ".CMS_TABLE_SUFIX."cms_termine WHERE datum >= '".date('Y')."-1-1' ORDER BY datum ASC";
$query=$mysql->Query($sql) or die(mysql_error());
while($row=mysql_fetch_assoc($query))
{
  $datum_start=icaldate($row['datum'], $row['beginn']);
  $datum_end=icaldate($row['datum_bis'], $row['bis']);

 $output .=
"BEGIN:VEVENT
SUMMARY:".get_right_text($tools->zeichenersetzungaus($row['termin']))."
UID:".$row['id']."
STATUS:CONFIRMED
DTSTART;TZID=Europe/Berlin:" . $datum_start . "
DTEND;TZID=Europe/Berlin:" . $datum_end . "
LAST-MODIFIED:" . $datum_start. "
LOCATION:".get_right_text($tools->zeichenersetzungaus($row['veranstaltungsort']))."
DESCRIPTION:".get_right_text($tools->zeichenersetzungaus($row['beschreibung']))."
END:VEVENT\n";
}

// close calendar
$output .= "END:VCALENDAR";
header("Content-type: text/calendar; charset=utf-8");
header("Content-Disposition: inline; filename=TEL.ics");
echo $output;
?>
