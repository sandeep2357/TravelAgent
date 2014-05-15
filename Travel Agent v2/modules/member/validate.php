<?php
//File Name:validate.php
//Desc: Validate registration process by passing code

if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
$index=1;
include("header.php");
$tpl=new Template();
$tpl->modTemplate("member");
$time=time()-86400;
$db->query("DELETE FROM  ".$prefix."_user_temp where user_regdate<$time");
//Get validate code
$id=intval($_GET["id"]);

//Find details from by the id number
$result=$db->query("SELECT * from ".$prefix."_user_temp WHERE user_code=$id");
//Put details into array
$user=$db->fetch_array($result);

//Check how many records found
$found=$db->row_count($result);
$time=time();

// check if the user already exist in the user table
$qcheck_user=$db->query("SELECT user_id FROM ".$prefix."_user WHERE user_email='$user[user_email]'");
$user_exist=$db->row_count($qcheck_user);

//If no record found by the id number  or user already exist then stop him there.
if($found<1){
	$tpl->display("no_temp_user_found.tpl");
	include("footer.php");
	exit;
}


//Code is valid now is it a reset password or new registration  request
//if it is 1,means reset else its a new registration
if(($user[user_pass_reset]==1) && ($user_exist>0)){
	$qupdate=$db->query("UPDATE ".$prefix."_user SET user_pass='$user[user_pass]' WHERE user_email='$user[user_email]'");
	if($qupdate){
		$tpl->display("update_password.tpl");
	}else{
		$tpl->assign("failed",1);
		$tpl->display("update_password.tpl");
		include("footer.php");
		exit;
	}

}else{
//It's new registration,so copy everything from user_temp table and insert into user table
	$qinsert=$db->query("INSERT INTO ".$prefix."_user(
	user_fname,user_lname,user_email,user_pass,user_phone,user_fax,
	user_mobile,user_addr,user_suburb,user_city,user_regdate)
	VALUES('$user[user_fname]','$user[user_lname]','$user[user_email]','$user[user_pass]','$user[user_phone]',
	'$user[user_fax]','$user[user_mobile]','$user[user_addr]','$user[user_suburb]',
	'$user[user_city]',$time)");
	$tpl->display("temp_user_registration_succes.tpl");

}
//Finally Delete from temporary table
$db->query("DELETE FROM ".$prefix."_user_temp WHERE  user_code=$id OR user_email='$user[user_email]'");

include("footer.php");



?>