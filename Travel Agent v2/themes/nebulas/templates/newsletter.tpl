<html>
<head>
<title>Newsletter Template</title>
<LINK REL="StyleSheet" HREF="http://www.YOURSITE.COM/themes/nebulas/css/style.css" TYPE="text/css">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<META NAME="DESCRIPTION" CONTENT="">
<META NAME="KEYWORDS" CONTENT="">
<META HTTP-EQUIV="EXPIRES" CONTENT="0">
<META NAME="RESOURCE-TYPE" CONTENT="DOCUMENT">
<META NAME="DISTRIBUTION" CONTENT="GLOBAL">
<META NAME="AUTHOR" CONTENT="">
<META NAME="COPYRIGHT" CONTENT="">
<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
<META NAME="REVISIT-AFTER" CONTENT="1 DAYS">
<META NAME="RATING" CONTENT="GENERAL">
{literal}
<SCRIPT LANGUAGE=javascript>
<!--
function OnChange(dropdown,url){
	var myindex = dropdown.selectedIndex
    var baseURL= url
    top.location.href = baseURL + dropdown.options[myindex].value;

    return true;
}
//-->
</SCRIPT>
{/literal}
</head>

<BODY BGCOLOR=#CAC0B2 LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 rightmargin="0" bottommargin="0" style="padding-top:5px ">
<center>

<table cellSpacing="0" cellPadding="0" width="747" border="0" id="table1">
	<tr>
		<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px">
		<img height="9" src="http://www.YOURSITE.COM/themes/nebulas/images/up-1.jpg" width="747" style="border: 0 none"></td>
	</tr>
	<tr>
		<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px; padding-left: 13px; padding-right: 18px; padding-top: 7px; padding-bottom: 0px" vAlign="top" width="747" background="http://www.YOURSITE.COM/themes/nebulas/images/back-up-1.jpg" height="100%">

		<a href="http://www.YOURSITE.COM/index.php"><img src="http://www.YOURSITE.COM/themes/nebulas/images/header2.gif" border="0" width="716"></a>

<table  width="716" align="center" height="32" background="http://www.YOURSITE.COM/themes/nebulas/images/menubg.gif">
<tr><td ><b>
 <a href="http://www.YOURSITE.COM/index.php" style="text-decoration:none;"><font color="#FFFFFF">Home</font></a> | <a href="http://www.lonelyplanet.com/destinations/" style="text-decoration:none;"><font color="#FFFFFF">Lonely Planet</font></a> | <a href="http://www.checkmytrip.com" style="text-decoration:none;"><font color="#FFFFFF">Check my iternary</a></font> | <a href="http://www.YOURSITE.COM/index.php?m=flightinformation" style="text-decoration:none;"><font color="#FFFFFF">Airport Departure/Arrival</font></a></td><td align="right"><b><font color="#FFFFFF">Call Us 555-555-5555</font></b>&nbsp;| <font color="#FFFFFF">Tuesday, June 17, 2007</font></b></td>
</tr>
</table>

<!--start -->
<table width="716" align="center" bgcolor="#ffffff">
<tr><td valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td valign="top">Dear <strong>{$user},</strong><p align="justify">{$content|nl2br}</p>
<br>
 Your Company Name.<br>
<br><br><small>&copy; Your Company Name. To unsubscribe  <a href="http://www.YOURSITE.COM/index.php?m=newsletter">click here.</a></small>
</td><td width="10"></td></tr>
</table>

</td><td bgcolor="#becffe">

{if $ad1.txt1!="" or $ad2.txt2!="" or $ad3.txt3!=""}
	<td valign="top" bgcolor="#becffe" width="220" height="100%">
	<p class="red" align="justify"> {$ad1.txt1|nl2br}
	</p>
	{if $ad1.img1}<center> <img src="{$ad1.img1}" align="absmiddle"></center>{/if}
	<br>
	<p class="red" align="justify"> {$ad2.txt2|nl2br}
	</p>
	{if $ad2.img2}
	<center>
	 <img src="{$ad2.img2}" align="absmiddle"></center>{/if}
	<br>
	<p class="red" align="justify"> {$ad3.txt3|nl2br}
	</p>

	{if $ad3.img3}<center> <img src="{$ad3.img3}" align="absmiddle"></center>{/if}
	<br>


{/if}
	</td>

</tr>
</table>

<!--end-->

</td>
	</tr>
	<tr>
		<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px">
		<img height="8" src="http://www.YOURSITE.COM/themes/nebulas/images/end-1.jpg" width="747" style="border: 0 none"></td>
	</tr>
	<tr>
		<td style="color: #725d3f; font-family: Tahoma; font-size: 11px; line-height: 12px; padding-right: 160px; padding-top: 9px" align="right">
		Copyright © YOURSITE.COM. All rights reserved.<a href="http://www.YOURSITE.COM/index.php?m=aboutus">About Us</a> | <a href="http://www.YOURSITE.COM/index.php?m=tac">Terms And Conditions</a></td>
	</tr>
</table>

</center>

</body>
</html>