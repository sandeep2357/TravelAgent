<?PHP
session_start();

require_once("mainfile.php");
$index=1;
include("header.php");
session_unset();
$_SESSION=array();
session_destroy();
echo"<center>You have been logged out successfully.<a href=index.php>Continue...</a></center>";
goto("index.php");
exit;
include("footer.php");


?>