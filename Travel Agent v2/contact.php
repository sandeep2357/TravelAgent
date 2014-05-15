<?php
//File : booking.php
//Date: 28/02/2005
//Desc : Booking details

if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	header("location:index.php");
	die();
}

require_once("mainfile.php");
include("header.php");
echo"Contact";
include("footer.php");


?>