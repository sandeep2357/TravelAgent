<?php
 session_start();
//File Name: login.php
//Desc:Login page

if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
$index=1;

function index(){
	session_start();
 	global $db,$prefix,$fingerprint;
 	include("header.php");
 	$tpl= new Template();
 	$tpl->modTemplate("member");
 	$code=random();
	smartyValidate::connect($tpl,empty($_POST));
	SmartyValidate::register_form('frm_member_login');
	$tpl->assign("code",$code);
 	if(empty($_POST)) {
			$tpl->display("login.tpl");
			$tpl->assign("code",$code);

	}else{
			 if(SmartyValidate::is_valid($_POST)) {
			 // no errors, done with SmartyValidate
				$uemail=$_POST["uemail"];
				$upass=md5($_POST["upass"]);
				$result=$db->query("Select user_id,user_email,user_fname,user_lname,user_pass FROM  ".$prefix."_user WHERE user_email='$uemail' AND user_pass='$upass'");
				$found=$db->row_count($result);
				$user=$db->fetch_array($result);
				if($found<1){
					$tpl->assign("uemail",$uemail);
					$tpl->assign("no_user_found","1");
					$tpl->display("login.tpl");
					include("footer.php");
					exit;
				}

			 $_SESSION["uid"]=$user["user_id"];
			 $_SESSION["email"]=$user["user_email"];
			 $_SESSION["password"]=$upass;
			 $_SESSION["name"]="$user[user_fname] $user[user_lname]";
			 $_SESSION["member"]=$fingerprint;
			 SmartyValidate::disconnect();
			 //session_regenerate_id();

			 goto("index.php?m=member","Taking you member section");
			 }else{
				$tpl->assign($_POST);
				$tpl->assign("code",$code);
				$tpl->display("login.tpl");

	}		}

	include("footer.php");
}


function scode(){
	global $fingerprint;
	$datekey = date("F j");
	$random_num=$_GET["code"];
	$rcode = hexdec(md5($_SERVER[HTTP_USER_AGENT] . $fingerprint . $random_num . $datekey));
	$code = substr($rcode, 2, 6);
	$image = ImageCreateFromJPEG("images/code.jpg");
	$text_color = ImageColorAllocate($image, 80, 80, 80);
	Header("Content-type: image/jpeg");
	ImageString ($image, 5, 12, 2, $code, $text_color);
	ImageJPEG($image, '', 75);
	ImageDestroy($image);

}

switch($op){
 default:
 index();
 break;

 case"scode":
 scode();
 break;

}

?>