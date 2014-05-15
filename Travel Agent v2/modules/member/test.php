<?php

$string = $_SERVER["HTTP_USER_AGENT"];
$string .= "telqJWKoq5gafRad3aZh3CMGFuKtLwTxe";
$fingerprint=md5($string);


	$datekey = date("F j");
	$random_num=$_GET["code"];
	$rcode = hexdec(md5($_SERVER[HTTP_USER_AGENT] . $fingerprint . $random_num . $datekey));
	$code = substr($rcode, 2, 6);
	$image = ImageCreateFromJPEG("images/code.jpg");
	$text_color = ImageColorAllocate($image, 80, 80, 80);
	Header("Content-type: image/jpeg");
	ImageString ($image, 5, 12, 2, $code, $text_color);
	ImageJPEG($image, '', 75);
	ImageDestroy($image);



?>