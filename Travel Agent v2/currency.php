<?php
 for MIT Project
//Currency Rate Grabber
//This script fetch Rate  From http://quote.yahoo.com and create xml file
putenv("TZ=NZ");

$countries=array(
"New Zealand"=>"NZD",
"Australia"=>"AUD",
"India"=>"INR",
"Malaysia"=>"MYR",
"Singapore"=>"SGD",
"UAE"=>"AED",
"UK"=>"GBP",
"Thailand"=>"THB",
"Euro"=>"EUR",
"Bangladesh"=>"BDT"

);

$file= fopen("currency.xml", "w");
$xml="<?xml version=\"1.0\" ?>\n<rss version=\"2.0\">\n<channel>\n";

foreach($countries as $k=>$country){
	$money[0]=@file("http://quote.yahoo.com/m5?a=1&t=$country&s=USD"); // set the value in the url (a=1.99)
	$xml.="<item>\n";
	$xml.="<country>".formatrss($k)."</country>\n";
	$xml.="<rate>";
	for($i=0; $i<sizeof($money); $i++)	{
	   $money[$i] = join("",$money[$i]);
	   $money[$i] = ereg_replace(".*<table border=1 cellpadding=2 cellspacing=0>",'',$money[$i]);
	   $money[$i] = ereg_replace("</table>.*",'',$money[$i]);
	   $money[$i] = ereg_replace("</b>.*",'',$money[$i]);
	   $money[$i] = ereg_replace(".*<b>",'',$money[$i]);
	   $xml.="$money[$i]";

	}
	$xml.="</rate>\n";
	$xml.="<currency>$country</currency>\n";
	$xml.="<lastupdate>".date("h:m:A")."</lastupdate>\n";
	$xml.="</item>\n";

}

$xml.="</channel>\n";
$xml.="</rss>\n";

//Make sure xml data is not empty
if(!empty($xml)){
	fwrite($file, $xml);
}
fclose($file);
echo"Done,we have created currency.xml file.";
function formatrss($text){
	//& (&amp;)
	//< (<lt;)
	//£ (£pound;)
	$text=eregi_replace( "&", "&amp;",$text);
	$text=eregi_replace( "<", "<lt;",$text);
	$text=eregi_replace( "£", "£pound;",$text);
	return $text;

}

?>