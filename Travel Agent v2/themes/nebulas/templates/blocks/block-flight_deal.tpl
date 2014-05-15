<table height="100%" cellSpacing="0" cellPadding="0" width="219" background="themes/nebulas/images/back-up-3.jpg" border="0" id="table1">
<tr>
	<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px">
	<img src="themes/nebulas/images/up-4.jpg" style="border: 0 none"></td>
</tr>
<tr>
	<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px; padding-left: 7px; padding-bottom: 12px; background-repeat: no-repeat; background-position: 50% bottom" vAlign="top" background="themes/nebulas/images/end-3.jpg" height="100%">
	<strong>Flight Deals</strong><br>
	<font class="bodynormal">{section name=idx loop="$continent"}<a href="index.php?m=package&continent={$continent[idx].continent_id}">{$continent[idx].continent_name}</a><br>{/section}</font></td>
</tr>
</table>

<!--
<table  cellpadding="1" cellpspacing="0"><tr><td bgcolor ="#006600">
<table border="0" width="150" cellpadding="2" bgcolor="#FFFFFF" nowrap>
<tr><td  bgcolor ="#006600"><font color="#FFFFFF"><b>{$title}</b></font></td></tr>
<tr><td>
<font class="bodynormal">{section name=idx loop="$continent"}<a href="index.php?m=package&continent={$continent[idx].continent_id}">{$continent[idx].continent_name}</a><br>{/section}</font></td>
</tr>
</table>
</td></tr></table>
-->
