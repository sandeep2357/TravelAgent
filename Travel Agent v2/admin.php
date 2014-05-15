<?php
#session_start();
#header("Cache-Control: private");
require_once("mainfile.php");
$index=1;


if (empty($_GET['file'])) {
  $file = "index";
} else {
  $file = addslashes($_GET['file']);
}

if (empty($_GET['m'])) {
  $folder = "admin";
} else {
  $folder = addslashes($_GET['m']);
}


if (ereg("\.\.",$file)) {
header("location:index");
exit;
}

$file ="$site_path/admin/$folder/$file.php";

if (file_exists("$file")) {
  include($file);
} else {

   header("location:index.php");
   include("header.php");
   echo"<center><h3>Ooops !,Invalid file request or such file does not exist</center></h3>";
   include("footer.php");
   exit;
}



?>