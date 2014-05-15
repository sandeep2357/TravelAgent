<?php
if (!eregi("index.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");
$index=1;
global $site_path,$db,$prefix,$site_host,$config;
$tpl= new Template();
$tpl->modTemplate("print");
$url=$_SERVER['HTTP_REFERER'];
$parsed_url = parse_url($url);
$server = $parsed_url['host'];
if((!$server== $site_host) || empty($url)){
	header("location:$site_url");
	exit;
}
$fd=fopen("$url","r");
$contents="";
$start = "<!--printstart-->";            // Start Grabbing Code
$stop  = "<!--printend-->";                 // Stop Grabbing Code
while ($line=fgets($fd,8192)){
	$contents.=$line;
}
fclose ($fd);

// Isolates desired section.
if(eregi("$start(.*)$stop", $contents, $printing)) {
	$substring=$printing[1];
	// while is added as there are multiple instances of the </table> string & eregi
	// searches to include the most that matches, not the next.
	while(eregi("(.*)$stop", $substring, $printing)) {
		$substring=$printing[1];
	};
	$printcontent=$printing[1];
} else {
	$printcontent="Sorry Nothing to print";
}
$tpl->assign("theme",$theme);
$tpl->assign("content",$printcontent);
$tpl->assign("sitetitle",$config[site_title]);
$tpl->assign("siteurl",$config[site_url]);
$tpl->display("print.tpl");

//include("footer.php");

?>