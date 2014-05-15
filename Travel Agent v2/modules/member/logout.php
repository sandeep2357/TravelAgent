<?php
//File Name: login.php
//Desc:Login page

if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
$index=1;

global $db,$prefix;
session_start();
include("header.php");
$tpl= new Template();
session_unset("email");
session_unset("password");
session_unset("fname");
session_unset("lname");
session_unset("uid");
session_destroy();
goto("index.php","Logged out successfully. Taking you home");
include("footer.php");


?>