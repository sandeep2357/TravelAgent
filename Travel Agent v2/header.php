<?
session_start();
if (eregi("header.php",$_SERVER['PHP_SELF'])) {
    Header("Location: index.php");
    die();
}
ob_start();

require_once("mainfile.php");
global $index,$page_title,$config,$lang;
$now=time();
$date=date("l, dS  F, Y  - h:i:s A",$now);
$headTemplate= new Template();
$header_array=array("header1.gif","header2.gif","header4.jpg");
$key = array_rand($header_array);
$headTemplate->assign("lang",$lang);
$headTemplate->assign("site_title","$config[site_title]-$page_title");
$headTemplate->assign("description",$config[site_desc]);
$headTemplate->assign("keywords",$config[site_keywords]);
$headTemplate->assign("author","");
$headTemplate->assign("copyright",$config[$site_title]);
$headTemplate->assign("date",$date);
$headTemplate->assign("random_header",$header_array[$key]);
$headTemplate->display("header.tpl");
if(($index==1) || ($index==3)){
 blocks("left");
}
$headTemplate->display("left_center.tpl");

//Url Rewritting Settings.

function replace_for_mod_rewrite(&$s){
	$in =array(
		"'(?<!/)index.php\?m=fare&id=([0-9]*)'",
		"'(?<!/)index.php\?m=package&file=packagedetails&id=([0-9]*)'"
		);
		$out=array(
		"fare\\1.html",
		"package\\1.html"
	);
		$s = preg_replace("(&amp;|&)","&", $s);
		$s = preg_replace($in, $out, $s);
	return $s;
}


?>

