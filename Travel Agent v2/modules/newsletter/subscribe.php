<?php
if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	header("location:index.php");
	die();
}

require_once("mainfile.php");
$index=1;
include("header.php");
$tpl=new Template();
$tpl->modTemplate("newsletter");
$c=intval($_GET["c"]);
if(empty($c)){
	goto("index.php");
	exit;
}
$past = time()-86400;
$db->query("DELETE FROM ".$prefix."_newsletter_user_temp WHERE user_date < $past");

$qcheck=$db->query("SELECT * FROM ".$prefix."_newsletter_user_temp WHERE user_code='$c'");
$found=$db->row_count($qcheck);
$user=$db->fetch_array($qcheck);
if($found>0){
	$qcheck2=$db->query("SELECT user_id FROM ".$prefix."_newsletter_user WHERE user_email='$user[user_email]'");
	$found2=$db->row_count($qcheck2);
	if($found2>0){
		$tpl->display("already_subscribed.tpl");
		include("footer.php");
		exit;
	}
	$qinsert=$db->query("INSERT INTO ".$prefix."_newsletter_user(user_name,user_email,user_date) values('$user[user_email]','$user[user_email]',$user[user_date])");
	$tpl->display("subscribe_success.tpl");
	$db->query("DELETE FROM ".$prefix."_newsletter_user_temp WHERE user_code=$c");
}else{
	$tpl->display("invalid_code.tpl");
}
include("footer.php");

?>