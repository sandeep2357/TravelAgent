<?php
//Search Block

if (eregi("block-search.php",$_SERVER["PHP_SELF"])) {
    Header("Location: ../index.php");
    die();
}
require_once("mainfile.php");
$tpl=new template();
$tpl->display("search.tpl");

?>