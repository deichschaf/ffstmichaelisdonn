<?PHP
require_once("../lib/init.php");
$vis=$http->Request('vis');
$vcard=$http->Request('vcard');
if ($vis=='')
{
	$vcard='';
}
else
{
	if(!is_numeric($vis))
	{
		$vcard='';
	}
}
if ($vcard=='mitglied')
{
	if ($vcard=='mitglied')
	{
		$sql="SELECT * FROM ".CMS_TABLE_SUFIX."cms_mitglieder WHERE cms_mitglieder_id=".$vis;
    $query=$mysql->Query($sql) or die(mysql_error());
    if (mysql_num_rows($query)==0)
    {
      $vcard='';
    }
  }
  else
  {
    $vcard='';
  }
}

if ($vcard=='')
{
	echo 'Es wurde keine Visitenkarte ausgew&auml;lt!';
	exit();	
}
else
{
$v = new vCard();
$row=mysql_fetch_assoc($query);

$v->setName(Tools::zeichenersetzungaus($row['nachname']), Tools::zeichenersetzungaus($row['vorname']), "", "");
$strasse='';
$plz='';
$ort='';
if ($row['strasse']!='' && $row['strasse']!=NULL  && $row['strasse']!='NULL')
{
	$strasse=Tools::zeichenersetzungaus($row['strasse']);
}
if ($row['plz']!='' && $row['plz']!=NULL  && $row['plz']!='NULL')
{
	$plz=Tools::zeichenersetzungaus($row['plz']);
}
if ($row['ort']!='' && $row['ort']!=NULL  && $row['ort']!='NULL')
{
	$ort=Tools::zeichenersetzungaus($row['ort']);
}
$v->setAddress("", "", $strasse, $ort, "", $plz, "Deutschland");

if ($row['telefon']!='' && $row['telefon']!=NULL  && $row['telefon']!='NULL')
{
	$telefon=str_replace('\'','',$row['telefon']);
	$telefon=str_replace('/','',$telefon);
	$telefon=str_replace('-','',$telefon);
	$telefon=str_replace(' ','',$telefon);
	$v->setPhoneNumber($telefon, "PREF;HOME;VOICE");
}

if ($row['telefon2']!='' && $row['telefon2']!=NULL  && $row['telefon2']!='NULL')
{
	$telefon=str_replace('\'','',$row['telefon2']);
	$telefon=str_replace('/','',$telefon);
	$telefon=str_replace('-','',$telefon);
	$telefon=str_replace(' ','',$telefon);
	$v->setPhoneNumber($telefon, "WORK");
}
if ($row['mobil']!='' && $row['mobil']!=NULL  && $row['mobil']!='NULL')
{
	$telefon=str_replace('\'','',$row['mobil']);
	$telefon=str_replace('/','',$telefon);
	$telefon=str_replace('-','',$telefon);
	$telefon=str_replace(' ','',$telefon);
	$v->setPhoneNumber($telefon, "CELL");
}

if ($row['emailadresse']!='' && $row['emailadresse']!=NULL  && $row['emailadresse']!='NULL')
{
	$v->setEmail($row['emailadresse']);
}

if ($row['emailadresse2']!='' && $row['emailadresse2']!=NULL  && $row['emailadresse2']!='NULL')
{
	$v->setEmail2($row['emailadresse2']);
}

if ($row['bild']!='' && $row['bild']!=NULL  && $row['bild']!='NULL')
{
	$v->setPhoto("JPEG",VORSTAND.$row['bild']);
}
if ($row['geburtstag']!='' && $row['sichtbar_geburtstag']=='1')
{
  $v->setBirthday($row['geburtstag']);
}
#$v->setNote("You can take some notes here.\r\nMultiple lines are supported via \\r\\n.");
#$v->setURL("http://www.thomas-mustermann.de", "WORK");

$output = $v->getVCard();
$filename = $v->getFileName();

Header("Content-Disposition: attachment; filename=$filename");
Header("Content-Length: ".strlen($output));
Header("Connection: close");
Header("Content-Type: text/x-vCard; name=$filename");

echo $output;
}
?>