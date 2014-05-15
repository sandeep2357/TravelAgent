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
$result=$db->query("SELECT news_id,news_title,news_sdesc FROM  travel_news ORDER BY news_id DESC LIMIT 7");
while($row=$db->fetch_array($result)){
	$news[] = $row;
}
$tpl-> assign('news', $news);
$tpl->display("news.tpl");
include("footer.php");

?>