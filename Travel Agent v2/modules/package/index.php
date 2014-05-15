<?php
//Display package

function index(){
	include("header.php");
	global $db,$lang,$prefix;
	$tpl=new Template();
	$tpl->modTemplate("package");
	$continent=intval($_GET["continent"]);
	if(!empty($continent)){
		$cond=" AND package_continent=$continent";
	}
	$result=$db->query("SELECT *  FROM ".$prefix."_package  WHERE  package_active=1 $cond");
	$num_record=$db->row_count($result);

	if($num_record<1){
		$tpl->display("no_package.tpl");
		include("footer.php");
		exit;
	}

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
	$page_link = makepagelink("index.php?m=package", $page, $pages);
	else
	$page_link = "";
	$result2=$db->query("SELECT * FROM ".$prefix."_package  WHERE package_active=1 $cond ORDER BY package_id DESC limit $start,$perpage");
	$tpl->assign("pagelink",$page_link);
	$tpl->assign("start", $starting_no);
	$tpl->assign("end",$end_count);
	$tpl->assign("found",$num_record);
	$tpl->assign("currentpage",$currentpage);
	while($row=$db->fetch_array($result2)){
		$package[]=$row;
	}
	$tpl->assign("lang",$lang);
	$tpl->assign("package",$package);
	$tpl->display("package.tpl");
	include("footer.php");
}



switch($op){
	default:
	index();
	break;

}
?>