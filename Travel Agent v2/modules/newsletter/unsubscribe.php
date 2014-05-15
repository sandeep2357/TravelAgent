<?php
if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	header("location:index.php");
	die();
}

require_once("mainfile.php");
global $prefix,$db;
include("header.php");
$tpl=new Template();
$tpl->modTemplate("newsletter");
$c=intval($_GET["c"]);
$past = time()-86400;
$db->query("DELETE FROM ".$prefix."_newsletter_user_temp WHERE user_date < $past");

$qcheck=$db->query("SELECT * FROM ".$prefix."_newsletter_user_temp WHERE user_code='$c'");
$found=$db->row_count($qcheck);
$user=$db->fetch_array($qcheck);
if($found>0){
	$db->query("DELETE FROM ".$prefix."_newsletter_user WHERE user_email='$user[user_email]'");
	$tpl->display("unsubscribe_success.tpl");
}else{
	$tpl->display("invalid_code.tpl");
}
include("footer.php");

?>