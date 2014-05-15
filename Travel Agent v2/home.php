<?php
if (!eregi("index.php",$_SERVER['PHP_SELF'])) {
    Header("Location: index.php");
    die();
}

require_once("mainfile.php");
include("header.php");
echo"home";
include("footer.php");

?>