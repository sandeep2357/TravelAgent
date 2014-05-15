<?php

//Description: Display Special fares and packages for wap devices
// send wml headers
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\""
   . " \"http://www.wapforum.org/DTD/wml_1.1.xml\">";
require_once("mainfile.php");
global $prefix,$db;
?>

<wml>
<card id="home" title="Our Company">
<p>Welcome to Our Company.
We offer the best prices in town.
Why pay more when you travel by the same  airlines ! </p>
<p>-----------------------</p>
<p><a href="#special">Fare Special</a></p>
<p><a href="#package">Package Special</a></p>
<p><a href="#contact">Contact Us</a></p>
<p>-----------------------</p>
<p><b><?php echo"$config[site_phone]"; ?></b></p>
</card>

<card id="special" title="Special Fare">
<p><a href="#home">Home</a>&gt;Specials</p>
<p><b><?php echo"$config[site_phone]</b>"; ?></p>
<p>
<?php
echo"<table columns=\"2\">";
echo"<tr><td><b>Fare</b></td><td><b>Price</b></td></tr>";
$result=$db->query("SELECT fare_title,fare_adultfare FROM ".$prefix."_fares WHERE fare_special=1 AND fare_active=1 LIMIT 10");
while($row=$db->fetch_array($result)){
	echo"<tr><td><small>$row[fare_title]</small></td><td><small>$$".intval($row[fare_adultfare])."</small></td></tr>";
}
echo"</table>";
?>
</p>
<p><a href="#home">Home</a></p>

</card>
<card id="package" title="Hot&nbsp;deals">
<p><a href="#home">Back</a> &gt;Packages</p>
<p>
<?php
echo"<table columns=\"2\">";
echo"<tr><td><b>Package</b></td><td><b>Price</b></td></tr>";
$result=$db->query("SELECT * FROM ".$prefix."_package LIMIT 10");
while($row=$db->fetch_array($result)){
	echo"<tr><td><small>$row[package_name]</small></td><td><small>$$$row[package_cost]</small></td></tr>";
}
echo"</table>";
?>
</p>
<p><a href="#home">Home</a></p>
</card>

<card id="contact" title="Contact Us">
<p>You can email us to info@yoursite.com <b>[Edit in wap.php]</b> or  <?php echo"$config[site_phone]"; ?></p>
<p><a href="#home">Home</a></p>
</card>
</wml>