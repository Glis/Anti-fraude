<?
{session_set_cookie_params(0); session_start();}
$_SESSION = array();
session_destroy();
header("Location: login.php");
exit;
?>