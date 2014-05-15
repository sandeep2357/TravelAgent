<?php
if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	die("You can't access this page directly.");
}

$index=2;
require_once("mainfile.php");
include("header.php");
$tpl=new Template();
$tpl->assign("lang",$lang);
$tpl->modTemplate("aboutus");
$tpl->display("aboutus.tpl");
include("footer.php");


?>
