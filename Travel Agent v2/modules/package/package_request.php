<?php
session_start();
if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	die();
}
$index=2;
require_once("mainfile.php");
$page_title="$lang[package_request]";

global $db,$lang;
include("header.php");
$smarty= new Template();
$smarty->modTemplate("package");
$id=intval($_GET["id"]);
$result=$db->query("SELECT  * FROM travel_package WHERE package_id=$id");
$package=$db->fetch_array($result);
$smarty->assign("lang",$lang);
 $smarty->assign("package",$package);

 // required initialization
    SmartyValidate::connect($smarty, empty($_POST));
	SmartyValidate::register_form("package_request");
    if(empty($_POST)) {
    $smarty->assign("lang",$lang);

       $smarty->display("package_request.tpl");
    } else {
       // validate after a POST
       if(SmartyValidate::is_valid($_POST)) {
           // no errors, done with SmartyValidate
           SmartyValidate::disconnect();
           $package_id=intval($_REQUEST["id"]);
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
          sendbooking_request($package_id,$fname,$lname,$email,$phone,$travel_date,$nopeople,$products,$msg);
       } else {
           // error, redraw the form
           $smarty->assign($_POST);
           $smarty->assign("lang",$lang);
           $smarty->display('package_request.tpl');
       }
    }
//$smarty->display("booking_request.tpl");
include("footer.php");


function sendbooking_request($package_id,$fname,$lname,$email,$phone,$travel_date,$nopeople,$products,$msg){
	global $db,$config,$lang;
	$smarty=new Template();
	$smarty->modTemplate("package");
	$result=$db->query("SELECT * FROM travel_package WHERE package_id=$package_id");
	$row=$db->fetch_array($result);
	$message="";
	$message.="#$lang[package_details]\n";
	$message.="--------------\n";
	$message.="$lang[package_id]: $row[package_id]\n";
	$message.="$lang[package_name]: $row[package_name]\n";
	$message.="$lang[price]: $$row[package_cost]\n";
	$message.="$lang[more_info]:\n";
	$message.="$config[site_url]/index.php?m=package&file=packagedetails&id=$row[package_id]\n\n";

	$message.="#$lang[customer_details]\n";
	$message.="------------------\n";
	$message.="$lang[full_name] : $fname  $lname\n";
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

	}
	if(!empty($msg)){
		$message.="\n";
		$message.="#$lang[comments]\n";
		$message.="-----------------\n";
		$message.="$msg";
	}
	sendmail($config[site_booking_email],"$lang[booking_request]",$message,$email,"$fname $lname");
	$tocustomer="";
	$tocustomer.="$lang[dear] $fname $lname.\n$lang[booking_thankyou]";
	$tocustomer.="$message";
	$tocustomer.="\n--------------------\n";
	$tocustomer.="\n$lang[thank_you_for_choosing_us]\n";
	$tocustomer.="$config[site_title]\n$config[site_url]";
	sendmail($email,"$lang[booking_reply_subject]",$tocustomer,$config[site_booking_email],"$config[site_title]");
	$smarty->assign("lang",$lang);
	$smarty->display("success_booking_request.tpl");
	goto("index.php",4);

}


?>
