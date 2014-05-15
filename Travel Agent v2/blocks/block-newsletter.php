<?
if (eregi("block-mailinglist.php",$_SERVER["PHP_SELF"])) {
    Header("Location: ../index.php");
    die();
}
require_once("mainfile.php");
$tpl=new template();
$tpl->assign("title","Join the mailing list");
$tpl->display("block-newsletter.tpl");

?>