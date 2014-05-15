<?php
session_start();
//File Name:register.php
//Desc: Registration page

if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
$index=1;
include("header.php");
$tpl=new Template();
$tpl->modTemplate("member");
smartyValidate::connect($tpl,empty($_POST));
SmartyValidate::register_form('frm_registration');


if(empty($_POST)) {
		$tpl->display("register.tpl");

}else{
		 if(SmartyValidate::is_valid($_POST)) {
		 		// no errors, done with SmartyValidate
		 		$randval=random();
		 		$time=time();
		 		$pass=md5($_POST[password]);
		 		$title=addslashes($_POST["title"]);
		 		$fname=addslashes($_POST["fname"]);
		 		$lname=addslashes($_POST["lname"]);
		 		$email=addslashes($_POST["email"]);
		 		$password=md5(addslashes($_POST["password"]));
		 		$phone=addslashes($_POST["phone"]);
		 		$fax=addslashes($_POST["fax"]);
		 		$mobile=addslashes($_POST["mobile"]);
		 		$addr=addslashes($_POST["addr"]);
		 		$suburb=addslashes($_POST["suburb"]);
		 		$city=addslashes($_POST["city"]);

				$result=$db->query("insert into ".$prefix."_user_temp(
				user_fname,user_lname,user_email,user_pass,user_phone,user_fax,user_mobile,user_addr,user_suburb,user_city,user_code,user_regdate)
				values('$fname','$lname','$email','$password',
				'$phone','$fax','$mobile','$addr','$suburb','$city','$randval','$time')");

		 	if($result){
		 		$message = "Dear $fname $lname ,\n\nTo become a member of $config[site_title] , please click on the following link \n$config[site_url]/index.php?m=member&file=validate&id=$randval \n\nRegards \n $config[site_title] \n $config[site_url]";
				$subject="Registration at $config[site_title]";
			 	sendmail($email,$subject,$message,"$config[site_title]","$config[site_contact_email]");
		 		$tpl->display("tempuser_sucess.tpl");
		 	}else{
		 		$tpl->display("tempuser_failed.tpl");
		 	}

		 }else{

			$tpl->assign($_POST);
			$tpl->display("register.tpl");
}		}


include("footer.php");

?>