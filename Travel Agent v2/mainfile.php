<?php
@putenv("TZ=NZ");
include("config.php");
include("db.php");
include("function.php");
include("libs/Smarty.class.php");
include("libs/SmartyValidate.class.php");
$db=new db($dbhost,$dbuser,$dbpass,$dbname);
$qconfig=$db->query("SELECT * FROM ".$prefix."_config");
$config=$db->fetch_array($qconfig);
$site_url=$config["site_url"];
$site_name=$config["site_name"];
$site_path=realpath(DIRNAME(_FILE));
$admin_email=$config["site_admin"];
$site_host=$_SERVER["HTTP_HOST"];
include("language/$config[site_language]");
$theme=$config["site_theme"];

$string = $_SERVER["HTTP_USER_AGENT"];
$string .= "telqJWKoq5gafRad3aZh3CMGFuKtLwTxe";
$fingerprint=md5($string);
define(FINGERPRINT,$fingerprint);


if(!isset($_GET["op"])){
$op="";
}else{
$op=addslashes($_GET["op"]);
}



class Template extends Smarty {

   function Template($path=""){
        global $theme,$site_path;
        $this->Smarty();
		$this->template_dir = "$site_path/themes/$theme/templates/";
		$this->compile_dir = "$site_path/themes/$theme/templates_c/";
		$this->compile_dir = "$site_path/cache/";
	   }

	function setTemplateDir($dir){
		global $site_path;
		$this->template_dir = "$site_path/$dir/templates/";
		$this->compile_dir = "$site_path/cache/";
       }

   function modTemplate($m){
       global $theme,$site_path;
       $this->Smarty();
       $this->template_dir = "$site_path/themes/$theme/templates/";
       $this->compile_dir = "$site_path/cache/";
      }

}

//blocks
function blocks($position=""){
	global $db;
	$tpl=new Template();
     if (strtolower($position[0]) == "l") {
	$position = "l";
    } elseif (strtolower($position[0]) == "r") {
		$position = "r";
    }

    if(is_admin()){
			$cond="AND block_viewby in(0,2)";
		}elseif(is_user()){
			$cond=" AND block_viewby in(0,1)";
		}else{
			$cond="AND block_viewby=0 ";
	}

	$qblock=$db->query("SELECT * FROM travel_blocks WHERE block_position='$position' AND block_active='1' $cond ORDER BY block_rank ASC");
	while($row=$db->fetch_array($qblock)){
		if(!empty($row["block_file"])){
			includeblockfile("$row[block_file]");
		}else{
				$row["block_content"]=stripslashes("$row[block_content]");
				includeblock($row[block_title],$row[block_content]);
		}
	}

}

//include block file (ie.block-news.php

function includeblockfile($file){
	global $site_path;
	include("$site_path/blocks/$file");
}

//include content from block table

function includeblock($title,$content){
	global $db;
	$tpl=new Template();
	$tpl->assign("content",$content);
	$tpl->assign("title",$title);
	$tpl->display("blocks.tpl");
}



function is_user(){
	@session_start();
	global $db,$prefix;
	if(!isset($_SESSION["email"])  || !isset($_SESSION["password"])) {
	 	return false;
	}else{
	   	$result=$db->query("Select user_id from ".$prefix."_user where user_email='$_SESSION[email]' AND user_pass='$_SESSION[password]'");
	  	$num=$db->row_count($result);
	  	if(($num !=1) || !defined("FINGERPRINT")){
			$_SESSION=array();
			$_SESSION["logged_in"]="";
			session_unset("email");
			session_unset("password");
			session_destroy();
			return false;
	   		}else{
	   		return true;
		}
	}
}


// send email
function sendmail($to,$subject,$message,$sender_name,$sender_email) {
	$mailheaders= "From:$sender_name<$sender_email>\n";
	$mailheaders.= "Reply-To: $sender_email\n\n";
	mail($to,$subject,$message,$mailheaders);

}

function goto($url,$time="",$msg=""){
	echo"<center>Processing<img src=\"images/redirecting.gif\" border=\"0\"></center>";
  	echo"<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
}

//Generate random number
function random() {
	$floor = 100000;
	$ceiling = 999999;
	srand((double)microtime()*1000000);
	$random = rand($floor, $ceiling);
	return $random;
}

function booking_type($type){
	if($type==0){
		$msg="One way";
	}elseif($type==1){
		$msg="Return";
	}else{
		$msg="Invalid";
	}

	return $msg;
}

function getrow($what="",$from="",$where="",$field=""){
	global $db;
	$result=$db->query("SELECT $what  FROM  $from WHERE $where='$field'");
	if($result){
	 list($whatx)=$db->fetch_row($result);
		 return $whatx;
	}else {
 	 	return false;
	 }
}

function arraycombine($array1, $array2) {
	$combined=array();
	for ($a=0; $a<count($array1); $a++) {

    $combined[$a] = $array1[$a] . '   ' . $array2[$a];
	}
	return $combined;
}

//Convert dd/mm/yyyy to unix timestamp
function unixDate($date){
	$dates=explode("/",$date);
	$day=$dates[0];
	$month=$dates[1];
	$year=$dates[2];
	$unixdate=date("U",mktime(0,0,0,$month,$day,$year,-1));
	return $unixdate;

}


function tounixdate($date){
	$dates=explode("/",$date);
	$day=$dates[0];
	$month=$dates[1];
	$year=$dates[2];
	$unixdate=date("U",mktime(0,0,0,$month,$day,$year,-1));
	return $unixdate;

}

function todate($date){
	if(empty($date)){
		return ;
	}
	$m=date("m",$date);
	$d=date("d",$date);
	$y=date("y",$date);
	$mdate="$d/$m/$y";
	return $mdate;
}

function is_admin(){
	@session_start();
	global $db,$fingerprint,$prefix;
	if(!isset($_SESSION["fingerprint"]) || empty($_SESSION["fingerprint"]) || $_SESSION["fingerprint"]!=$fingerprint){
		return false;
		 session_destroy();
		exit;
	}
	$result=$db->query("SELECT * FROM ".$prefix."_config  WHERE site_admin='$_SESSION[admin]' AND site_pass='$_SESSION[adminpass]'");
	$found=$db->row_count($result);
	if($found==1) {
		return true;
	}else{
		return false;
		 session_destroy();
	}

}


//Counter
$ip=getIP();

// Get the Browser name
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if( ereg("Nav|Gold|X11|Netscape", $user_agent) AND
    !ereg("MSIE|Konqueror|Slurp|AppleWeb|Firefox", $user_agent) ) $browser = "Netscape";
elseif(ereg("MSIE", $user_agent)) $browser = "MSIE";
elseif(ereg("Opera", $user_agent)) $browser = "Opera";
elseif(ereg("Konqueror", $user_agent)) $browser = "Konqueror";
elseif(ereg("Firefox", $user_agent)) $browser = "Firefox";
elseif( eregi("bot|ia_arch|Feedread|Popos|find|Google|Slurp|Scooter|Spider|Infoseek", $user_agent) ) $browser = "Bot";
elseif(ereg("Mozilla", $user_agent)) $browser = "Mozilla";
else $browser = "Other";

// Get the Operating System name

if(ereg("Win", $user_agent)) $os = "Windows";
elseif( ereg("Mac|PPC", $user_agent ) ) $os = "Mac";
elseif(ereg("Linux", $user_agent)) $os = "Linux";
elseif(ereg("FreeBSD", $user_agent)) $os = "FreeBSD";
elseif(ereg("SunOS", $user_agent)) $os = "SunOS";
elseif(ereg("BeOS", $user_agent)) $os = "BeOS";
elseif(ereg("OS/2", $user_agent)) $os = "OS/2";
else $os = "Other";

//Don't catch own domain referrer
if( strstr(!$_SERVER['HTTP_REFERER'],$_SERVER[HTTP_HOST])){
	$referer=$_SERVER["HTTP_REFERER"];
}


@$db->query("INSERT INTO  ".$prefix."_counter(counter_ip,counter_browser,counter_os,counter_time,counter_referer) VALUES('$ip','$browser','$os',now(),'$referer')");

//Who is online
$time=time();
$expire=$time-600; // (in seconds)
$ip=getIP();
$host=@gethostbyaddr("$ip");
$db->query("DELETE FROM  ".$prefix."_visitor where visitor_expiry_time<$expire");
$result=$db->query("SELECT visitor_id FROM ".$prefix."_visitor WHERE visitor_ip='$ip'");
if($db->row_count($result)>0){
	$db->query("UPDATE  ".$prefix."_visitor SET visitor_expiry_time=$time WHERE visitor_ip='$ip'");
}else{
	$db->query("INSERT INTO ".$prefix."_visitor(visitor_ip,visitor_host,visitor_visit_time,visitor_expiry_time) values('$ip','$host',$time,$time)");
}

//Get Actual ip if came through proxy, credit php.net helpfile

function getIP() {
	if (getenv("HTTP_CLIENT_IP")){
		$ip = getenv("HTTP_CLIENT_IP");
	}elseif(getenv("HTTP_X_FORWARDED_FOR")) {
		$ip = getenv("HTTP_X_FORWARDED_FOR");

	}elseif(getenv("REMOTE_ADDR")) {
		$ip = getenv("REMOTE_ADDR");

	}else{
		$ip = "127.0.0.1";
	}
	return $ip;

}





?>