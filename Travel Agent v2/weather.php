<?
/*
Author: Dadan Ramdan
Email : thenewhiking@yahoo.com
Description: Simple Weather using weather.com
Version: 1.0
Last Changed: 21 October 2004
usage:
todo:
get id for your city first
http://xoap.weather.com/search/search?where=jakarta

get the id for jakarta. on this sample jakarta have id= IDXX0022
put in the id on variabel $location_id
*/

// Sign up for Weather.com's free XML service at http://www.weather.com/services/xmloap.html
$partner_id="1007868156";
$license_key="2896f652f06c5ba9";
$location_id="IDXX0022";

//dont change this part
$needle1="<cc>";
$needle2="</cc>";
$nedTMP1="<tmp>";
$nedTMP2="</tmp>";

$contents = '';
$posln=0;
$currentW='';

$handle = fopen("http://xoap.weather.com/weather/local/$location_id?cc=*&dayf=2&prod=xoap&par=[$partner_id]&key=[$license_key]", "rb");


while (!feof($handle)) {
  $contents .= fread($handle, 8192);
}
fclose($handle);


$pos1      = strpos($contents, $needle1);

if ($pos1 === false) {
   echo "Sorry, we did not find ($needle1) in ($contents)";
} else {

	$pos2      = strpos($contents, $needle2);

	if ($pos2 === false) {
   		echo "Sorry, we did not find ($needle2) in ($contents)";
	} else {
		$posln=$pos2-$pos1;
   		$currentW= substr($contents,$pos1+4,$posln-4);
	}
}


$posTW1=  strpos($currentW, $nedTMP1);


if ($posTW1 === false) {
   echo "Sorry, we did not find ($nedTMP1) in ($currentW)";
} else {

	$posTW2=  strpos($currentW, $nedTMP2);

	if ($posTW2 === false) {
   		echo "Sorry, we did not find ($nedTMP2) in ($currentW)";
	} else {
		$posTWLN=$posTW2-$posTW1;
   		$TEMPERATURF=substr($currentW,$posTW1+5,$posTWLN-5);
	}
}

$TEMPERATURC=(5/9)*($TEMPERATURF-32);
echo "Fahrenheit: $TEMPERATURF Celcius: $TEMPERATURC";
?>
