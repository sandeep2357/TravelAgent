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
$smarty->modTemplate("fare");

SmartyValidate::connect($smarty);
SmartyValidate::register_form('friend_fare');
$link= $_REQUEST["link"];
$id=intval($_REQUEST["id"]);
$smarty->assign("id",$id);
$url="index.php?m=fare&id=$id";

$result=$db->query("SELECT  fare_id,fare_title,fare_adultfare,destination_name,origin_name,fare_id,fare_adultfare,fare_purchaseby,fare_airline,airline_logo,airline_name,airline_nick
FROM travel_fares,travel_destination,travel_origin,travel_airline,travel_fares_origin
WHERE fare_id=$id
AND destination_id=fare_destination
AND  fares_origin=origin_id AND fare_active=1
AND airline_id=fare_airline");
$smarty->assign("id",$id);
$row=$db->fetch_array($result);
$smarty->assign("fare",$row);
$friends=$_POST["friends"];
$smarty->assign("friends",$friends);

    if(empty($_POST)) {
       $smarty->display('mail.tpl');
    } else {
       // validate after a POST
       if(SmartyValidate::is_valid($_POST)) {
           // no errors, done with SmartyValidate
           $uemail=$_POST["uemail"];
           $name=$_POST["uname"];
           $email2=$_POST["email2"];
           $subject="::$row[origin_name] >> $row[destination_name] $$row[fare_adultfare]";
       		$msg="Hi,\nYour friend $name has sent the following fare to check out\n$config[site_url]/$url\n\n $config[site_title]\n $config[site_url]";
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