<?php

//Desc: Dynamic file loader
//Date: 26/02/2005

if(strpos(strtoupper($_SERVER["HTTP_ACCEPT"]),"VND.WAP.WML") > 0){
	header("location:wap.php");
	exit;
}

//load mainfile which has database connection,templateloader,common functions etc
require_once("mainfile.php");

// Check input variables . Input GET variables  A to Z character or 0 to 9 numbers are allowed.
//Other character are invalid . Good protection for SQL injection. ie id= ' DROP TABLE employee

switch ($_SERVER["REQUEST_METHOD"]) {
 /*
 case "GET":
     while (list ($key, $val) = each ($_GET)) {
     if ( ereg("[^a-zA-Z0-9]",$val)) {
      header("location:index.php");
	  die("Forbiden words.Your ip has been recorded.");
	 }
   }
    break;
    */
  }


//if input variable file is empty then load default file home.php
if (empty($_GET['file'])) {
  $file = 'index';
} else {
  $file =$_GET["file"];
}

//modules
if(empty($_GET["m"])){
	$module="$config[site_default_module]";
}else{
	$module=$_GET["m"];
}


//if input variable has back slash,probably someone trying to view passwd file.so block him

if (ereg("\.\.",$file)) {
  die("You are so cool...,Hack somewhere else");
}

$file ="$site_path/modules/$module/$file.php";

//If file physically exist in the sever then include it otherwise redirect to default page
if(file_exists("$file")) {
  include($file);
} else {
	include("header.php");
   echo"<center><h3>Oops ! Invalid file request or such file does not exist.</center></h3>";
   include("footer.php");
}

?>