<?php

if(!eregi("index.php",$_SERVER["PHP_SELF"])){

die("You can't access this page directly.");

}



$index=4;



require_once("mainfile.php");

$page_title="Flight Information";

include("header.php");

$tpl= new Template();

$tpl->modTemplate("flightinformation");

$act=$_REQUEST["act"];

if(empty($act)){

	$act="a";

}

$act_opt=array("a"=>"Arrivals","d"=>"Departures");

$tpl->assign("act_opt",$act_opt);



$tpl->assign("act",$act);



$result=$db->query("SELECT * FROM ".$prefix."_flights WHERE flight_action='$act'");

$flight=$db->fetch_array($result);

$tpl->assign("lang",$lang);





$tpl->assign("flight",$flight);

$tpl->display("flightinformation.tpl");

include("footer.php");



?>

