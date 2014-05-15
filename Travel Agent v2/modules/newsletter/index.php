<?php
if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	header("location:index.php");
	die();
}
$index=1;
require_once("mainfile.php");
global $config;
$page_title="Mailing list";
include("header.php");
$email=addslashes($_POST["email"]);
$name=addslashes($_POST["uname"]);
$what=intval($_POST["what"]);
$random=random();
$tpl=new Template();
$tpl->modTemplate("newsletter");

if(empty($name) || empty($email)){
 	$tpl->assign("uname",$name);
 	$tpl->assign("email",$email);
	$tpl->display("mailinglist.tpl");
	include("footer.php");
	exit;

}

$qcheck=$db->query("SELECT user_id FROM ".$prefix."_newsletter_user WHERE user_email='$email'");
$found=$db->row_count($qcheck);
$time=time();
$qinsert=$db->query("INSERT INTO ".$prefix."_newsletter_user_temp(user_name,user_email,user_date,user_code) values('$email','$email',$time,'$random')");
if(!$qinsert){
	$tpl->display("mailinglist_failed.tpl");
	include("footer.php");
	exit;
}

if($what==1){
	if($found>0){
		$tpl->display("already_subscribed.tpl");
		include("footer.php");
		exit;
	}
	$msg="Hi $name\n\nTo complete your subscription to $config[site_title] newsletter, please click on the following link:\n\n $config[site_url]/index.php?m=newsletter&file=subscribe&c=$random\n\n\nThank you\n$config[site_title]\n$config[site_url]";

	//send email
	sendemail("$email","Subscription at $config[site_title]","$msg","$config[site_contact_email]","$config[site_title]");
	//echo"$email,Subscription at $config[site_title],$msg,$config[site_contact_email],$config[site_title]";
	$tpl->display("subscribe_mailsent.tpl");

}elseif($what==0){
	if($found>0){
		$msg="Hi $name\n\nTo unsubscribe from $config[site_title] newsletter,please click on the following link:\n\n $config[site_url]/index.php?m=newsletter&file=unsubscribe&c=$random\n\n\nThank you\n$config[site_title]\n$config[site_url]";
		//send email
		sendemail("$email","Unsubscribe at $config[site_title]","$msg","$config[site_contact_email]","$config[site_title]");
		$tpl->display("unsubscribe_mailsent.tpl");
		include("footer.php");
		exit;
	}else{
		$tpl->display("no_user_found.tpl");
		include("footer.php");
		exit;

	}
}else{
	header("index.php");
}

include("footer.php");

?>