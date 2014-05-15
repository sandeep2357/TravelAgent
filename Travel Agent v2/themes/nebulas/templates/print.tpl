<html>
<head>
<title>{$title}</title>
{literal}
<script>
function printWindow(){
   bV = parseInt(navigator.appVersion)
   if (bV >= 4) window.print()
}
</script>
{/literal}
<LINK REL="StyleSheet" HREF="themes/{$theme}/style/style.css" TYPE="text/css">
</head>
<body onload="printWindow();">
<h1>{$sitetitle}</h1>
<table width=100% align="center"><tr><td align="justify">

{$content|replace:"<br />":"<br>"}
</td>
</tr>
</table>
<div align="center"> Printed on <b>{$smarty.now|date_format:"%d %b %Y"}</b>  from  <b>{$sitetitle}</b> </div>

</body>
</html>
