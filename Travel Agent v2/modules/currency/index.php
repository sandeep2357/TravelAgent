<?php

if(!eregi("index.php",$_SERVER["PHP_SELF"])){

die("You can't access this page directly.");

}



$index=1;



require_once("mainfile.php");

$page_title="Currency Converter";





function index(){

	global $db,$site_path;

	include("header.php");

	$tpl= new Template();

	$tpl->modTemplate("currency");



	$handle = fopen("$site_path/currency.xml", "r");

	$data="";

	while (!feof($handle)) {

	   $buffer = fgets($handle, 4096);

	    $data.="$buffer";

	}

	fclose($handle);

	for ($i=0;$i<10;$i++) {

		$items = explode("</item>",$data);

		$indexx=$i;

		$country = ereg_replace(".*<country>","",$items[$i]);

		$country=ereg_replace("</country>.*","",$country);



		$currency = ereg_replace(".*<currency>","",$items[$i]);

		$currency=ereg_replace("</currency>.*","",$currency);



		$lastupdate = ereg_replace(".*<lastupdate>","",$items[$i]);

		$lastupdate=ereg_replace("</lastupdate>.*","",$lastupdate);





		$rate = ereg_replace(".*<rate>","",$items[$i]);

		$rate = ereg_replace("</rate>.*","",$rate);



		$currency_array[$indexx]["country"]=$country;

		$currency_array[$indexx]["currency"]=$currency;

		$currency_array[$indexx]["rate"]=$rate;

		$option[]="$rate";



	}

	$option=implode(",",$option);



	$tpl->assign("option",$option);

	$tpl->assign("lastupdate",$lastupdate);

	$tpl->assign("currency",$currency_array);

	$tpl->display("currency.tpl");

	include("footer.php");



}







switch($op){

	default:

	index();

	break;

}







?>

