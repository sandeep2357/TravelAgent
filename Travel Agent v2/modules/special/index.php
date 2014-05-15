<?php

if(!eregi("index.php",$_SERVER["PHP_SELF"])){

die("You can't access this page directly.");

}



$index=2;



require_once("mainfile.php");

$page_title=$lang["special_page_title"];





function index(){

	global $db,$lang,$prefix;

	include("header.php");

	$result=$db->query("SELECT *	FROM  ".$prefix."_fares WHERE  fare_special=1 AND fare_active=1 ORDER BY fare_id");

	$tpl= new Template();

	$tpl->modTemplate("special");

	$num_record=$db->row_count($result);



	if(isset($_GET['page']))

	$page=intval($_GET['page']);

	else $page=1;



	$currentpage=$page;



	$perpage =20;

	$start=($page-1) * $perpage;

	$pages=ceil($num_record/$perpage);



	$starting_no = $start + 1;



	if ($num_record - $start<$perpage) {

	   $end_count = $num_record;

	} elseif ($num_record - $start >= $perpage) {

	   $end_count = $start + $perpage;

	}



	if($pages>1)

	$page_link = makepagelink("index.php?m=special", $page, $pages);

	else

	$page_link = "";

	// Fix the problem

	$result=$db->query("SELECT *	FROM  ".$prefix."_fares WHERE  fare_special=1 AND fare_active=1  ORDER BY fare_id DESC

	LIMIT $start,$perpage");

	$found=$db->row_count($result);

	$tpl->assign("found",$found);

	$tpl->assign("lang",$lang);

	$tpl->assign("pagelink",$page_link);

	$tpl->assign("start", $starting_no);

	$tpl->assign("end",$end_count);

	$tpl->assign("found",$found);

	$tpl->assign("currentpage",$currentpage);



	while($row=$db->fetch_array($result)){

		$special[]=$row;

		$tpl->assign("date","".todate($row[fare_purchaseby])."");

		$q=$db->query("SELECT * from travel_airline WHERE airline_id=$row[fare_airline]");

		$airline=$db->fetch_array($q);

		$tpl->assign("airline",$airline);

		$tpl->assign("special",$special);



	}

	$tpl->display("specialindex.tpl");

	include("footer.php");



}







switch($op){

	default:

	index();

	break;

}







?>