<?php

require_once("mainfile.php");
if (eregi("block-member.php",$_SERVER["PHP_SELF"])) {
    Header("Location: ../index.php");
    die();
}
 $tpl= new Template();
 $tpl->assign("title","Member Block");
 $tpl->display("blocks/member.tpl");


?>