<?php
header("Cache-Control: max-age=60");
if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
$index=2;
global $op;
function index(){
	global $site_path,$db,$prefix,$site_host,$config,$lang;
	include("header.php");
	$id=intval($_GET["id"]);
	$tpl= new Template();
	$tpl->modTemplate("package");
	$result=$db->query("SELECT * FROM travel_package WHERE package_id=$id AND package_active=1");
	$row=$db->fetch_array($result);

	$content=explode("<break>","$row[package_desc]");
	$num_record=count($content);
	if(isset($_GET['page']))
	$page=intval($_GET['page']);
	else $page=1;
	$currentpage=$page;
	$perpage =1;
	$start=($page-1) * $perpage;
	$pages=ceil($num_record/$perpage);
	$starting_no = $start + 1;

	if ($num_record - $start<$perpage) {
		$end_count = $num_record;
	} elseif ($num_record - $start >= $perpage) {
		$end_count = $start + $perpage;
	}

	if($pages>1)
	$page_link =makepagelink("index.php?m=package&file=packagedetails&id=$id", $page, $pages);
	else
	$page_link = "";

	$arrayelement = (int)$page;
	$arrayelement --;
	if(is_admin()){
		$link="<a href=index.php?file=admin&op=editpackage&id=$row[package_id]>Edit</a>";
	}else{
		$link="";
	}
	$contentx=nl2br($content[$arrayelement]);
	$q=$_SERVER["QUERY_STRING"];
	$url="$config[site_url]/index.php?$q";
	$tpl->assign("phone",$config[site_phone]);

	$tpl->assign("lang",$lang);
	$tpl->assign("id",$id);
	$tpl->assign("link",$url);
	$tpl->assign("pagelink",$page_link);
	$tpl->assign("start", $starting_no);
	$tpl->assign("end",$end_count);
	$tpl->assign("found",$num_record);
	$tpl->assign("currentpage",$currentpage);
	$tpl->assign("package",$row);
	$tpl->assign("content",$contentx);
	$tpl->display("package_details.tpl");
	include("footer.php");
}


function viewPackageFile(){
	global $db,$prefix;
	$id=intval($_GET["id"]);
	$result=$db->query("SELECT * FROM ".$prefix."_package WHERE package_id=$id");
	$file=$db->fetch_array($result);
	header("Content-type: $file[package_file_type]");
	header("Content-length: $file[package_file_size]");
	header("Content-Disposition: attachment; filename=$file[package_file_name]");
	header("Content-Description: PHP Generated Data");
  	echo $file[package_file];

}
switch($op){

	default:
	index();
	break;


	case"viewPackageFile":
	viewPackageFile();
	break;


}


?>