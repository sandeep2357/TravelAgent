<?php

//Desc: Default Module

if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	header("location:index.php");
	die();
}
$index=1;
$page_title="Main Page";

require_once("mainfile.php");
global $db;
$tpl=new Template();
#$index=$tpl->fetch("setup.tpl");
#$index=$index;
include("header.php");

//random image
$array=array("hadi1.jpg","hadi2.jpg","hadi3.jpg","hadi4.jpg");
$key=array_rand($array);
$randompix=$array[$key];
$tpl->assign("randompix",$randompix);

$result=$db->query("SELECT  * FROM ".$prefix."_fares WHERE fare_special=1 AND  fare_active=1 ORDER BY fare_id  DESC LIMIT 8");

while($row=$db->fetch_array($result)){
	$special[]=$row;

}

$qpackage=$db->query("SELECT * FROM  ".$prefix."_package ORDER BY rand() LIMIT 7");
while($row2=$db->fetch_array($qpackage)){
	$package[]=$row2;
}
$tpl->assign("lang",$lang);
$tpl->assign("adminlink",$adminlink);
$tpl->assign("package",$package);
$tpl->assign("special",$special);
$tpl->display("home/home.tpl");
include("footer.php");



?>
