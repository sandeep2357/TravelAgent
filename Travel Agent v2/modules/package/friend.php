<?php
session_start();

if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	header("location:index.php");
	die();
}
$index=2;

require_once("mainfile.php");
global $db;
$page_title="$lang[booking_request]";

include("header.php");

$smarty =& new Template();
$smarty->modTemplate("package");

SmartyValidate::connect($smarty);
SmartyValidate::register_form('friend_package');
$link= $_REQUEST["link"];
$id=intval($_REQUEST["id"]);
$smarty->assign("id",$id);
$url="index.php?m=package&file=packagedetails&id=$id";
$result=$db->query("SELECT *  FROM ".$prefix."_package  WHERE  package_active=1 AND package_id=$id");
$package=$db->fetch_array($result);
$smarty->assign("package",$package);

if(empty($_POST)) {
   $smarty->display('mail.tpl');
} else {
   // validate after a POST
   if(SmartyValidate::is_valid($_POST)) {
	   // no errors, done with SmartyValidate
	   $uemail=$_POST["uemail"];
	   $name=$_POST["uname"];
	   $email2=$_POST["email2"];
	   $subject="::$package[package_name] $package[package_cost]";
	  $msg="Hi,\nYour friend $name has sent the following travel package to check out\n$config[site_url]/$url\n\n $config[site_title]\n $config[site_url]";
	   sendmail($email2,$subject,$msg,$name,$uemail);
	   SmartyValidate::disconnect();
	   $smarty->display('success.tpl');
   } else {

	   // error, redraw the form
	   $smarty->assign($_POST);
	   $smarty->display('mail.tpl');
   }
}

include("footer.php");

?>
