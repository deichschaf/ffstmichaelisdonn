<?PHP
require_once('../lib/init.php');
Intern::check_extern_login($http, $mysql);
$id=$http->request('id');
print Newsletter::viewNewsletter($id, $mysql);
?>