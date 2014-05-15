<?php
session_start();
//File Name:lostpass.php
//Description: Registration page

if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
$index=1;
include("header.php");
$tpl=new Template();
$tpl->modTemplate("member");
smartyValidate::connect($tpl,empty($_POST));
SmartyValidate::register_form('frm_lostpass');

if(empty($_POST)) {
		$tpl->display("lostpass.tpl");

}else{
		 if(SmartyValidate::is_valid($_POST)) {
		 // no errors, done with SmartyValidate
			$uemail=addslashes($_POST["uemail"]);
			$result=$db->query("Select user_id,user_fname,user_lname  FROM  ".$prefix."_user WHERE user_email='$uemail'");
			list($uid,$fname,$lname)=$db->fetch_row($result);
			$found=$db->row_count($result);
			$upass=md5(addslashes($_POST["upass"]));
			$code=random();
			$user=$db->fetch_array($result);
			if($found<1){
				$tpl->assign("no_user_found","1");
				$tpl->assign("uemail",$uemail);
				$tpl->display("lostpass.tpl");
				include("footer.php");
				exit;
			}
			$time=time();
		  SmartyValidate::disconnect();
		  $result=$db->query("insert into ".$prefix."_user_temp(user_email,user_pass,user_code,user_regdate,user_pass_reset)
		  values('$uemail','$upass',$code,$time,1)");
		  if($result){
				$message = "Dear, $fname $lname,\n\nYou have requested to reset password at  $config[site_title].\nPlease click on the following link to reset.\n$config[site_url]/index.php?m=member&file=validate&id=$code\n\nIf this is an error,please delete this email.\n\nRegards,\n$config[site_title]\n$config[site_url]\n\n ";
				$subject="Reseting password at $config[site_title]";
				sendmail($uemail,$subject,$message,"$config[site_title]","$config[site_contact_email]");
				$tpl->display("lostpassmailsent.tpl");

		  }
		 }else{
			$tpl->assign($_POST);
			$tpl->display("lostpass.tpl");
}		}

include("footer.php");
?>