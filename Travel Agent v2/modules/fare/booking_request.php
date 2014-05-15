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
$pagla=new Template();
$pagla->modTemplate("fare");
$id=intval($_GET["id"]);
$result=$db->query("SELECT  fare_id,fare_title,fare_adultfare,destination_name,fare_id,fare_adultfare,fare_purchaseby,fare_airline,airline_logo,airline_name,airline_nick
FROM travel_fares,travel_destination,travel_origin,travel_airline
WHERE fare_id=$id
AND destination_id=fare_destination
AND fare_active=1
AND fare_special=1
AND airline_id=fare_airline");

$row=$db->fetch_array($result);
$pagla->assign("lang",$lang);
$pagla->assign("fare",$row);
$pagla->assign("id",$id);

 // required initialization
    SmartyValidate::connect($pagla, empty($_POST));
	SmartyValidate::register_form('booking_request');
    if(empty($_POST)) {
       $pagla->display('booking_request.tpl');
    } else {
       // validate after a POST
       if(SmartyValidate::is_valid($_POST)) {
           // no errors, done with SmartyValidate
           $fare_id=intval($_REQUEST["id"]);
           $fname=$_POST["fname"];
           $lname=$_POST["lname"];
           $phone=$_POST["phone"];
           $email=$_POST["email"];
           $nopeople=$_POST["nopeople"];
           $travel_date=$_POST["date1"];
           if(is_array($_POST["product"])){
           	foreach($_POST["product"] as $value){
           		$products[]=$value;
           	}
           }
           $msg=$_POST["msg"];
           SmartyValidate::disconnect();
            sendbooking_request($fare_id,$fname,$lname,$email,$phone,$travel_date,$nopeople,$products,$msg);
           //$pagla->display('success.tpl');
       } else {
           // error, redraw the form
           $pagla->assign("lang",$lang);
           $pagla->assign($_POST);
           $pagla->display('booking_request.tpl');
       }
    }
//$pagla->display("booking_request.tpl");
include("footer.php");


function sendbooking_request($fare_id,$fname,$lname,$email,$phone,$travel_date,$nopeople,$products,$msg){
	global $db,$config,$lang;
	$pagla=new Template();
	$pagla->modTemplate("fare");

	$result=$db->query("SELECT  fare_id,destination_name,fare_id,fare_adultfare,fare_purchaseby,fare_airline,airline_logo,airline_name,airline_nick
	FROM travel_fares,travel_destination,travel_origin,travel_airline
	WHERE fare_id=$fare_id
	AND destination_id=fare_destination
	 AND fare_active=1
	AND airline_id=fare_airline");
	$row=$db->fetch_array($result);
	$message="";
	$message.="#Fare Details\n";
	$message.="--------------\n";
	$message.="$lang[fare_id]: $fare_id\n";
	$message.="$lang[price]: $$row[fare_adultfare]\n";
	$message.="$lang[airline]:$row[airline_name]\n";
	#$message.="$lang[origin]:$row[origin_name]\n";
	$message.="$lang[destination]: $row[destination_name]\n";
	$message.="$lang[more_info]:\n";
	$message.="$config[site_url]/index.php?m=fare&id=$fare_id\n\n";

	$message.="#$lang[customer_details]\n";
	$message.="------------------\n";
	$message.="$lang[full_name] : $fname , Last Name: $lname\n";
	$message.="$lang[phone_no]. :$phone\n";
	$message.="$lang[email]: $email\n";
	$message.="$lang[travelling_date]: $travel_date\n";

	$message.="$lang[no_of_people]: $nopeople\n\n";
	if(!empty($products)){
		$message.="#$lang[additional_request]\n";
		$message.="--------------------\n";
		if(is_array($products)){
			foreach($products as $value){
				$message.="$value\n";
			}
		}
		$message.="\n";
	}
	if(!empty($msg)){
		$message.="#$lang[comments]\n";
		$message.="-----------------\n";
		$message.="$msg\n\n";
	}
	sendmail($config[site_booking_email],"$lang[booking_request]",$message,$email,"$fname $lname");
	$tocustomer="";
	$tocustomer.="$lang[dear] $fname $lname\n$lang[booking_thankyou]";
	$tocustomer.="$message";
	$tocustomer.="--------------------\n";
	$tocustomer.="\n$lang[thank_you_for_choosing_us]\n";

	sendmail($email,"$lang[booking_reply_subject]",$tocustomer,$config[site_booking_email],"$config[site_title]");
	$pagla->assign("lang",$lang);
	$pagla->display("success_booking_request.tpl");
	goto("index.php",4);

}


?>
