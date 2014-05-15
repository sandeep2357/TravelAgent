<?php
//Load Mainfile, if the this file is called directly
//from the browser,direct to mainpage
require_once("mainfile.php");
global $db,$prefix;
if (eregi("block-.flight_deal",$_SERVER["PHP_SELF"])) {
    Header("Location: ../index.php");
    die();
}
$result=$db->query("SELECT * FROM ".$prefix."_continent");
while($row=$db->fetch_array($result)){
	$continent[]=$row;
}
//Create new object
 $tpl= new Template();
//Set block title
 $tpl->assign("title","Flight Deals in..");
//Set block content
 $tpl->assign("continent",$continent);
 $tpl->display("blocks/block-flight_deal.tpl");


?>