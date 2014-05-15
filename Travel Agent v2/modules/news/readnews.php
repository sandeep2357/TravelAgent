<?php
if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}
require_once("mainfile.php");
$index=2;
global $db,$prefix;
$tpl=new Template();
$tpl->modTemplate("news");
include("header.php");
$id=intval($_GET["id"]);
$result=$db->query("SELECT * FROM travel_news WHERE news_id=$id ORDER BY news_id DESC");
$row=$db->fetch_array($result);
$tpl->assign('news',$row);
$tpl->display("readnews.tpl");
include("footer.php");

?>