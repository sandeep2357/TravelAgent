<?php
session_start();
//File Name: home.php
//Desc: Main page

if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
include("modules/member/language/lang-english.php");
$index=1;

if(!is_user()){
	include("header.php");
	goto("index.php?m=member&file=login","Taking you to login page");
	include("footer.php");
	exit;

}
function index(){
 	global $db,$prefix;
 	include("header.php");
 	$tpl=new Template();
 	$tpl->modTemplate("member");
	$tpl->display("welcome.tpl");
	include("footer.php");
}

function profile(){
	session_start();
	global $db,$prefix;
	include("header.php");
	$tpl= new Template();
	$tpl->modTemplate("member");
	smartyValidate::connect($tpl,empty($_POST));
	SmartyValidate::register_form('frm_profile');

	$id=$_SESSION["uid"];
	$result=$db->query("SELECT * FROM ".$prefix."_user WHERE user_id=$id");
	$user=$db->fetch_array($result);
	$tpl->assign("user",$user);
	$found=$db->row_count($result);
	if($found<1){
		$tpl->display("no_user_found.tpl");
		include("footer.php");
		exit;
	}

	if(empty($_POST)) {
			$tpl->display("profile.tpl");

	}else{
			 if(SmartyValidate::is_valid($_POST)) {
			 		// no errors, done with SmartyValidate
			 		$randval=random();
			 		$time=time();
			 		$title=addslashes($_POST["title"]);
			 		$fname=addslashes($_POST["fname"]);
			 		$lname=addslashes($_POST["lname"]);
			 		$email=addslashes($_POST["email"]);
			 		$phone=addslashes($_POST["phone"]);
			 		$fax=addslashes($_POST["fax"]);
			 		$mobile=addslashes($_POST["mobile"]);
			 		$addr=addslashes($_POST["addr"]);
			 		$suburb=addslashes($_POST["suburb"]);
			 		$city=addslashes($_POST["city"]);

					$result=$db->query("UPDATE  ".$prefix."_user
					SET user_fname='$fname',
					user_lname='$lname',
					user_email='$email',
					user_phone='$phone',
					user_fax='$fax',
					user_mobile='$mobile',
					user_addr='$addr',
					user_suburb='$suburb',
					user_city='$city'
					WHERE user_id=$_SESSION[uid]");

			 	if($result){
					 	$tpl->display("profile_updated.tpl");
			 	}else{
			 		$tpl->display("profile_failed.tpl");
			 	}

			 }else{

				$tpl->assign($_POST);
				$tpl->display("profile.tpl");
	}		}


	include("footer.php");


}


function password(){
	session_start();
	global $db,$prefix;
	include("header.php");

	$tpl= new Template();
	$tpl->modTemplate("member");
	smartyValidate::connect($tpl,empty($_POST));
	SmartyValidate::register_form('frm_password');

	if(empty($_POST)) {
			$tpl->display("password.tpl");

	}else{
			 if(SmartyValidate::is_valid($_POST)) {
			 		// no errors, done with SmartyValidate
			 		$randval=random();
			 		$time=time();
			 		$pass=md5(addslashes($_POST["password"]));
			 		$oldpass=md5(addslashes($_POST["oldpass"]));

					$result=$db->query("Select user_id FROM  ".$prefix."_user WHERE user_email='$_SESSION[email]' AND user_pass='$oldpass'");
					$found=$db->row_count($result);
					if($found<1){
						$tpl->assign("old_password","1");
						$tpl->display("member/password.tpl");
						include("footer.php");
						exit;
					}

					$result=$db->query("UPDATE  ".$prefix."_user
					SET user_pass='$pass' WHERE user_id=$_SESSION[uid]");

			 	if($result){
					 	$tpl->display("password_changed.tpl");
			 	}else{
			 		$tpl->display("password_change_failed.tpl");
			 	}

			 }else{

				$tpl->assign($_POST);
				$tpl->display("password.tpl");
			}
	}

	include("footer.php");

}


function mybooking(){
	session_start();
	global $db,$prefix,$lang;
	include("header.php");
	$tpl=new Template();
	$tpl->modTemplate("member");
	$result=$db->query("SELECT  * FROM ".$prefix."_user_booking JOIN ".$prefix."_origin ON user_booking_origin=origin_id JOIN ".$prefix."_destination ON user_booking_destination=destination_id AND user_booking_user=$_SESSION[uid]");
	$num_record=$db->row_count($result);
	if($num_record<1){
		$tpl->assign("no_record","no_record");
		$tpl->assign("lang",$lang);
		$tpl->display("mybooking.tpl");
		include("footer.php");
		exit;
	}

	if(isset($_GET['page']))
	$page=intval($_GET['page']);
	else $page=1;

	$currentpage=$page;

	$perpage =15;
	$start=($page-1) * $perpage;
	$pages=ceil($num_record/$perpage);

	$starting_no = $start + 1;

	if ($num_record - $start<$perpage) {
	$end_count = $num_record;
	} elseif ($num_record - $start >= $perpage) {
	$end_count = $start + $perpage;
	}

	if($pages>1)
	$page_link = makepagelink("index.php?m=member&op=mybooking", $page, $pages);
	else
	$page_link = "";

	$result=$db->query("SELECT  * FROM ".$prefix."_user_booking
	LEFT JOIN ".$prefix."_origin ON user_booking_origin=origin_id
	LEFT JOIN ".$prefix."_destination ON user_booking_destination=destination_id
	LEFT JOIN ".$prefix."_airline ON user_booking_airline=airline_id
	lEFT JOIN ".$prefix."_class ON user_booking_class=class_id
	AND user_booking_user=$_SESSION[uid] ORDER BY user_booking_id DESC LIMIT $start,$perpage");

	while($row=$db->fetch_array($result)){
		$booking[]=$row;
	}
	$tpl->assign("lang",$lang);
	$tpl->assign("found",$num_record);
	$tpl->assign("page_link",$page_link);
	$tpl->assign("end_count",$end_count);
	$tpl->assign("starting_no",$starting_no);
	$tpl->assign("currentpage","$currentpage/$pages");

	$tpl->assign("booking",$booking);
	$tpl->display("mybooking.tpl");
	include("footer.php");


}

function bdetails(){
	session_start();
	global $db,$prefix,$lang;
	include("header.php");
	$id=intval($_GET["id"]);
	$tpl=new Template();
	$tpl->modTemplate("member");
	$qbooking=$db->query("SELECT  * FROM ".$prefix."_user_booking
	LEFT JOIN ".$prefix."_origin ON user_booking_origin=origin_id
	LEFT JOIN ".$prefix."_destination ON user_booking_destination=destination_id
	LEFT JOIN ".$prefix."_airline ON user_booking_airline=airline_id
	lEFT JOIN ".$prefix."_class ON user_booking_class=class_id
	lEFT JOIN ".$prefix."_faretype ON user_booking_type=type_id
	AND user_booking_user=$_SESSION[uid] WHERE user_booking_id=$id AND  user_booking_user=$_SESSION[uid]");


	$booking=$db->fetch_array($qbooking);

	$qpassenger=$db->query("SELECT * FROM ".$prefix."_passenger WHERE passenger_booking=$id");
	while($pa=$db->fetch_array($qpassenger)){
		$passenger[]=$pa;
	}


	$tpl->assign("lang",$lang);
	$tpl->assign("passenger",$passenger);
	$tpl->assign("booking",$booking);
	$tpl->display("booking_details.tpl");
	include("footer.php");




}



switch($op){
 	default:
 	index();
	break;

	case"profile":
	profile();
	break;


	case"password";
	password();
	break;

	case"mybooking":
	mybooking();
	break;

	case"bdetails":
	bdetails();
	break;


}

?>