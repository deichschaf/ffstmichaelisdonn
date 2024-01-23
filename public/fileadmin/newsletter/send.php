<?
require_once('../lib/init.php');
$id=$http->request('id');
Newsletter::sendmail($id, $mysql);
?>