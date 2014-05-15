<?php
@putenv("TZ=NZ");
require_once("mainfile.php");
$today=time();

$result=$db->query("DELETE    FROM ".$prefix."_fares  WHERE  fare_purchaseby<$today");
$db->query("DELETE  FROM ".$prefix."_package  WHERE  package_expire<$today");

?>