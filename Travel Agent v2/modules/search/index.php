<?php
//File : search.php

if(!eregi("index.php",$_SERVER["PHP_SELF"])){
	header("location:index.php");
	die();
}

$index=2;
global $op;
require_once("mainfile.php");

function index(){
	session_start();
	global $db,$prefix;
	include("header.php");
	$tpl= new Template();

	smartyValidate::connect($tpl,empty($_POST));
	SmartyValidate::register_form('fare_search');
	//set
	$origin=intval($_REQUEST["origin"]);
	$destination=intval($_REQUEST["destination"]);
	if($_POST["departure"]){
		$departure=tounixdate($_POST["departure"]);
	}else{
		$departure=$_GET["departure"];
	}

	$faretype=intval($_REQUEST["faretype"]);
	$class=intval($_REQUEST["class"]);
	$airline=intval($_REQUEST["airline"]);
	$tpl->assign("origin",$origin);
	$tpl->assign("destination",$destination);
	$tpl->assign("class",$class);
	$tpl->assign("faretype",$faretype);

	//fare type
	$qtype=$db->query("SELECT * FROM travel_faretype");
	while(list($type_id,$type_name)=$db->fetch_row($qtype)){
			$type_opt[$type_id]=$type_name;
	}

	//Origin
	$qorigin=$db->query("SELECT origin_id,origin_name FROM travel_origin ORDER BY origin_name ASC ");
	$origin_opt=array();
	while(list($origin_id,$origin_name)=$db->fetch_row($qorigin)){
		$origin_opt[$origin_id]=$origin_name;
	}


	//Destination
	$qdestination=$db->query("SELECT destination_id,destination_name FROM travel_destination JOIN
	{$prefix}_fares ON destination_id=fare_destination
	ORDER BY destination_name ASC");
	$destination_opt=array();
	while(list($destination_id,$destination_name)=$db->fetch_array($qdestination)){
		$destination_opt[$destination_id]=$destination_name;
	}

	// Airlines
	$qairline=$db->query("SELECT airline_id,airline_name FROM travel_airline");
	$airline_opt=array();
	while(list($airline_id,$airline_name)=$db->fetch_array($qairline)){
		$airline_opt[$airline_id]=$airline_name;
	}

	// Class
	$qclass=$db->query("SELECT class_id,class_name FROM travel_class");
	$class_opt=array();
	while(list($class_id,$class_name)=$db->fetch_array($qclass)){
		$class_opt[$class_id]=$class_name;
	}

	 if(!isset($_GET[page]) && empty($_POST)) {
	 		$tpl->assign("origin_opt",$origin_opt);
			$tpl->assign("destination_opt",$destination_opt);
			$tpl->assign("airline_opt",$airline_opt);
			$tpl->assign("class_opt",$class_opt);
			$tpl->assign("type_opt",$type_opt);
			$tpl->assign("lang",$lang);
			$tpl->display("search/search.tpl");

	}else{
		 if(SmartyValidate::is_valid($_POST)) {
		 // no errors, done with SmartyValidate
			$tpl->assign($_POST);
			$tpl->assign("origin_opt",$origin_opt);
			$tpl->assign("destination_opt",$destination_opt);
			$tpl->assign("airline_opt",$airline_opt);
			$tpl->assign("class_opt",$class_opt);
			$tpl->assign("type_opt",$type_opt);
			$tpl->assign("lang",$lang);

			$tpl->display("search/search.tpl");
			SmartyValidate::disconnect();
			$origin=intval($_REQUEST["origin"]);
			$destination=intval($_REQUEST["destination"]);
			if($_POST["departure"]){
				$departure=tounixdate($_POST["departure"]);
			}else{
				$departure=$_GET["departure"];
			}

			$faretype=intval($_REQUEST["faretype"]);
			$class=intval($_REQUEST["class"]);
			$airline=intval($_REQUEST["airline"]);
			//goto("index.php?m=search&op=search&origin=$origin&destination=$destination&departure=$departure&faretype=$faretype&class=$class&airline=$airline","Processing");
			$faretype=intval($_REQUEST["faretype"]);
			$class=intval($_REQUEST["class"]);
			$airline=intval($_REQUEST["airline"]);

			$query="SELECT * FROM ".$prefix."_fares,".$prefix."_fares_origin
			WHERE fare_id= fares_fare AND fares_origin =$origin 	AND fare_destination='$destination'";

			if(!empty($faretype)){
					$query.=" AND fare_type=$faretype";
			}

			if(!empty($class)){
						$query.=" AND fare_class=$class";
			}

			if(!empty($airline)){
				$query.=" AND fare_airline=$airline";
			}
			if(!empty($departure)){
				$query.=" AND $departure BETWEEN  fare_dept_start AND  fare_dept_end";
			}
			$qsearch=$db->query($query);
			$num_record=$db->row_count($qsearch);
			if($num_record<1){
				$tpl->assign("norecord","norecord");
				$tpl->assign("lang",$lang);
				$tpl->display("search/search_result.tpl");
				include("footer.php");
				exit;
			}

			if(isset($_GET['page']))
			$page=intval($_GET['page']);
			else $page=1;

			$currentpage=$page;

			$perpage =10;
			$start=($page-1) * $perpage;
			$pages=ceil($num_record/$perpage);

			$starting_no = $start + 1;

			if ($num_record - $start<$perpage) {
			   $end_count = $num_record;
			} elseif ($num_record - $start >= $perpage) {
			   $end_count = $start + $perpage;
			}

			if($pages>1)
			$page_link = makepagelink("index.php?m=search&origin=$origin&destination=$destination&departure=$departure&class=$class&faretype=$faretype&airline=$airline", $page, $pages);
			else
			$page_link = "";

			$result=$db->query("$query  AND fare_active=1 ORDER BY   fare_adultfare ASC limit $start,$perpage");

			while($row=$db->fetch_array($result)){
				$indexx=$row[fare_id];
				$info[$indexx]=$row;
				$info[$indexx]["airline"]=getrow("airline_name","travel_airline","airline_id","$row[fare_airline]");


			}


			$originName=getrow("origin_name","".$prefix."_origin","origin_id","$origin");
			$destinationName=getrow("destination_name","".$prefix."_destination","destination_id","$destination");

			$tpl->assign("lang",$lang);
			$tpl->assign("fareinfo",$info);
			$tpl->assign("found",$num_record);
			$tpl->assign("destinationName",$destinationName);
			$tpl->assign("originName",$originName);
			$tpl->assign("page_link",$page_link);
			$tpl->assign("end_count",$end_count);
			$tpl->assign("starting_no",$starting_no);
			$tpl->assign("currentpage","$currentpage/$pages");
			$tpl->display("search/search_result.tpl");



		 }else{
				$tpl->assign("origin_opt",$origin_opt);
				$tpl->assign("destination_opt",$destination_opt);
				$tpl->assign("airline_opt",$airline_opt);
				$tpl->assign("class_opt",$class_opt);
				$tpl->assign("type_opt",$type_opt);
				$tpl->assign("lang",$lang);


			$tpl->assign($_POST);
			$tpl->display("search/search.tpl");

	}
}
	include("footer.php");
}

function search(){
	//This is old function not using any more,but left it incase need it.
	//it has been integrated with the above index function
	global $db,$lang,$prefix;
	include("header.php");
	$pagla=new Template();
	$origin=intval($_REQUEST["origin"]);
	$destination=intval($_REQUEST["destination"]);
	if($_POST["departure"]){
		$departure=tounixdate($_POST["departure"]);
	}else{
		$departure=$_GET["departure"];
	}

	$faretype=intval($_REQUEST["faretype"]);
	$class=intval($_REQUEST["class"]);
	$airline=intval($_REQUEST["airline"]);

	$query="SELECT * FROM ".$prefix."_fares,".$prefix."_fares_origin
	WHERE fare_id= fares_fare AND fares_origin =$origin 	AND fare_destination='$destination'";

	if(!empty($faretype)){
			$query.=" AND fare_type=$faretype";
	}

	if(!empty($class)){
				$query.=" AND fare_class=$class";
	}

	if(!empty($airline)){
		$query.=" AND fare_airline=$airline";
	}
	if(!empty($departure)){
		$query.=" AND $departure BETWEEN  fare_dept_start AND  fare_dept_end";
	}

	$qsearch=$db->query($query);
	$num_record=$db->row_count($qsearch);
	if($num_record<1){
		$pagla->assign("norecord","norecord");
		$pagla->assign("lang",$lang);
		$pagla->display("search/search_result.tpl");
		include("footer.php");
		exit;
	}

	if(isset($_GET['page']))
	$page=intval($_GET['page']);
	else $page=1;

	$currentpage=$page;

	$perpage =15;
	$start=($page-1) * $perpage;
	$pages=ceil($num_record/$perpage);

	$starting_no = $start + 1;

	if ($num_record - $start<$perpage) {
	   $end_count = $num_record;
	} elseif ($num_record - $start >= $perpage) {
	   $end_count = $start + $perpage;
	}

	if($pages>1)
	$page_link = makepagelink("index.php?m=search&op=search&origin=$origin&destination=$destination&departure=$departure&class=$class&faretype=$faretype&airline=$airline", $page, $pages);
	else
	$page_link = "";

	$result=$db->query("$query  AND fare_active=1 ORDER BY   fare_adultfare ASC limit $start,$perpage");

	while($row=$db->fetch_array($result)){
		$indexx=$row[fare_id];
		$info[$indexx]=$row;
		$info[$indexx]["airline"]=getrow("airline_name","travel_airline","airline_id","$row[fare_airline]");


	}


	$originName=getrow("origin_name","".$prefix."_origin","origin_id","$origin");
	$destinationName=getrow("destination_name","".$prefix."_destination","destination_id","$destination");

	$pagla->assign("lang",$lang);
	$pagla->assign("fareinfo",$info);
	$pagla->assign("found",$num_record);
	$pagla->assign("destinationName",$destinationName);
	$pagla->assign("originName",$originName);
	$pagla->assign("page_link",$page_link);
	$pagla->assign("end_count",$end_count);
	$pagla->assign("starting_no",$starting_no);
	$pagla->assign("currentpage","$currentpage/$pages");
	$pagla->display("search/search_result.tpl");
	include("footer.php");
}

function searchnormal(){
	global $db,$lang,$prefix;
	include("header.php");
	$pagla=new Template();
	$origin=addslashes($_REQUEST["origin"]);
	$destination=addslashes($_REQUEST["destination"]);

	if(empty($origin) && empty($destination)){

		header("location:index.php?m=search");
	}

	//query
	$qorigin=$db->query("SELECT origin_name  FROM ".$prefix."_origin WHERE origin_name LIKE '%$origin%'");
	list($originName)=$db->fetch_row($qorigin);

	$qd=$db->query("SELECT destination_name FROM ".$prefix."_destination WHERE destination_name LIKE '%$destination%'");
	list($destinationName)=$db->fetch_row($qd);


	$query="SELECT * FROM ".$prefix."_fares,".$prefix."_fares_origin,".$prefix."_origin,".$prefix."_destination
	 WHERE fare_active=1
	AND fare_id= fares_fare AND fares_origin =origin_id
	AND fare_destination=destination_id";

	if(!empty($origin)){
	$query.=" AND origin_name LIKE'%$origin%'";
	}

	if(!empty($destination)){
	$query.=" AND destination_name LIKE '%$destination%'";
	}

	$qsearch=$db->query($query);
	$num_record=$db->row_count($qsearch);
	if($num_record<1){
		$pagla->assign("norecord","norecord");
		$pagla->assign("lang",$lang);
		$pagla->display("search/search_result.tpl");
		include("footer.php");
		exit;
	}

	if(isset($_GET['page']))
	$page=intval($_GET['page']);
	else $page=1;

	$currentpage=$page;

	$perpage =15;
	$start=($page-1) * $perpage;
	$pages=ceil($num_record/$perpage);

	$starting_no = $start + 1;

	if ($num_record - $start<$perpage) {
	   $end_count = $num_record;
	} elseif ($num_record - $start >= $perpage) {
	   $end_count = $start + $perpage;
	}

	if($pages>1)
	$page_link = makepagelink("index.php?m=search&op=searchnormal&origin=$origin&destination=$destination", $page, $pages);
	else
	$page_link = "";

	$result=$db->query("$query  ORDER BY   fare_adultfare ASC limit $start,$perpage");

	while($row=$db->fetch_array($result)){
		$indexx=$row[fare_id];
		$info[$indexx]=$row;
		$info[$indexx]["airline"]=getrow("airline_name","travel_airline","airline_id","$row[fare_airline]");


	}


	#$originName=getrow("origin_name","".$prefix."_origin","origin_id","$origin");
	#$destinationName=getrow("destination_name","".$prefix."_destination","destination_id","$destination");

	$pagla->assign("lang",$lang);
	$pagla->assign("fareinfo",$info);
	$pagla->assign("found",$num_record);
	$pagla->assign("destinationName",$destination);
	$pagla->assign("originName",$origin);
	$pagla->assign("page_link",$page_link);
	$pagla->assign("end_count",$end_count);
	$pagla->assign("starting_no",$starting_no);
	$pagla->assign("currentpage","$currentpage/$pages");
	$pagla->display("search/search_result.tpl");
	include("footer.php");
}




switch($op){
	default:
	index();
	break;

	case"search":
	search();
	break;


	case"searchnormal":
	searchnormal();
	break;

}



?>
