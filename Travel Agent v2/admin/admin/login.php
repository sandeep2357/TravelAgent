<?php
//File Name: login.php
//Desc:Login page

if (!eregi("admin.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
$index=1;

function index(){
 	global $db,$prefix,$fingerprint;
 	session_start();
 	include("header.php");
 	$tpl= new Template();
	$tpl->setTemplateDir("admin");
 	$code=random();

	smartyValidate::connect($tpl,empty($_POST));
	SmartyValidate::register_form('frm_adminlogin');
	$tpl->assign("code",$code);
 	if(empty($_POST)) {
			$tpl->display("admin_login.tpl");
			$tpl->assign("code",$code);

	}else{
			 if(SmartyValidate::is_valid($_POST)) {
			 // no errors, done with SmartyValidate
				$name=$_POST["name"];
				$pass=md5($_POST["pass"]);
				$result=$db->query("SELECT * FROM  ".$prefix."_config WHERE site_admin='$name' AND site_pass='$pass'");
				$row=$db->fetch_array($result);
				$found=$db->row_count($result);
				if($found<1){
					$tpl->assign("name",$name);
					$tpl->assign("no_user_found","1");
					$tpl->display("admin_login.tpl");
					include("footer.php");
					exit;
				}
			  SmartyValidate::disconnect();
			  	#session_start();
			 	#session_regenerate_id();
				$_SESSION["admin"]=trim($row["site_admin"]);
				$_SESSION["adminpass"]=trim($row["site_pass"]);
				$_SESSION["fingerprint"]=$fingerprint;
				goto("admin.php","Taking you member section");
			 }else{
				$tpl->assign($_POST);
				$tpl->assign("code",$code);
				$tpl->display("admin_login.tpl");
	}		}

	include("footer.php");
}


function scode(){
	global $fingerprint;
	$datekey = date("F j");
	$random_num=$_GET["code"];
	$rcode = hexdec(md5($_SERVER[HTTP_USER_AGENT] . $fingerprint . $random_num . $datekey));
	$code = substr($rcode, 2, 6);
	$image = ImageCreateFromJPEG("modules/member/images/code.jpg");
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