<?

//Desc : File Loader

if (eregi("footer.php",$_SERVER['PHP_SELF'])) {
    Header("Location: index.php");
    die();
}
require_once("mainfile.php");
global $index,$config;
$tpl= new Template();
global $index;
  if (($index ==1) || ($index==2)) {
		$tpl->display("center_right.tpl");
		blocks(right);
  }
$tpl->assign("copyright",$config[site_title]);
$tpl->display("footer.tpl");
$contents = ob_get_contents(); // store buffer in $contents
ob_end_clean(); // delete output buffer and stop buffering
echo replace_for_mod_rewrite($contents); //display modified buffer to screen

?>