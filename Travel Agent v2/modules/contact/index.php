<?
session_start();
if(eregi("home.php",$_SERVER["PHP_SELF"])){
header("location:index.php");
die();
}

$index=2;

$page_title="Contact us";


require_once("mainfile.php");
global $config;

include("header.php");
$tpl= new Template();
$tpl->modTemplate("contact");
smartyValidate::connect($tpl, empty($_POST));
SmartyValidate::register_form('contact_us');
	 $tpl->assign("lang",$lang);
$tpl->assign("phone",$config[site_phone]);
if(empty($_POST)) {
	 $tpl->assign("lang",$lang);
	$tpl->display('contact.tpl');
}
else{
		   // validate after a POST
		   if(SmartyValidate::is_valid($_POST)) {
			   // no errors, done with SmartyValidate
			   	$uname=$_POST['uname'];
			   	$message=$_POST['message'];
			   	$subject=$_POST['subject'];
			   	$uemail=$_POST['uemail'];
			   	$nicemessage="$message\n\n\n-----------------------------\nSender :$uname\n Message:$message\n";
			   	mail ("$config[site_contact_email]", "$subject",$nicemessage, "From: $uemail\nX-Mailer: PHP");
				$tpl->display("thankyou.tpl");

			} else {
			   // error, redraw the form
			$tpl->assign("lang",$lang);
			   $tpl->assign($_POST);
			   $tpl->display('contact.tpl');
		   }
}

include("footer.php");



?>