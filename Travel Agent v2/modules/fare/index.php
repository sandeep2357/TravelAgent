<?php

if(!eregi("index.php",$_SERVER["PHP_SELF"])){

	die("You can't access this page.");

}



$index=2;



$page_title="Fare details";

require_once("mainfile.php");



global $db,$lang;

$id=intval($_GET["id"]);

include("header.php");

$tpl=new template();

$tpl->modTemplate("fare");

$result=$db->query("select fare_title,fare_stay_min,fare_stay_max,class_name,airline_name,origin_name,destination_name,airline_logo,fare_id,fare_adultfare,fare_dept_start,fare_dept_end,fare_destination,fare_restriction,fare_purchaseby,fare_note

from travel_fares,travel_airline,travel_origin,travel_destination,travel_restfaretype,travel_class

WHERE fare_airline=airline_id

AND fare_id=$id

AND fare_active=1

AND fare_class=class_id

AND destination_id=fare_destination");

$row=$db->fetch_array($result);



$result2=$db->query("SELECT restr_faretype FROM travel_restfaretype WHERE  restr_faretypeid='$row[fare_restriction]'") ;

list($restriction)=$db->fetch_row($result2);

$tpl->assign("phone",$config[site_phone]);

$tpl->assign("lang",$lang);

$tpl->assign("fare",$row);

$tpl->assign("restriction",$restriction);

$tpl->display("fare_index.tpl");

include("footer.php");



?>

