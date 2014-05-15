<table height="100%" cellSpacing="0" cellPadding="0" width="219" background="themes/nebulas/images/back-up-3.jpg" border="0" id="table1">
<tr>
	<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px">
	<img src="themes/nebulas/images/up-4.jpg" style="border: 0 none"></td>
</tr>
<tr>
	<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px; padding-left: 7px; padding-bottom: 12px; background-repeat: no-repeat; background-position: 50% bottom" vAlign="top" background="themes/nebulas/images/end-3.jpg" height="100%">
	<strong>Currency Rate Information</strong><br>
	<small>1 USD equivalent of </small><hr>
	<font class="bodynormal">
	<table width="100%">
	{foreach from=$currency item=currency key=cid}
	<tr><td><small>{$currency.country}</small></td><td>
	{$currency.currency}</td><td>{$currency.rate}</td></tr>
	{/foreach}</font>
	
	<tr><Td colspan="3"><hr><a href="index.php?m=currency">Currency Coverter</a></td>
	<tr><td colspan="3" align="center"><small><b>Updated on {$lastupdate}</b></small></td></tr>
</table>
	
	</td>
</tr>
</table>
<!--

<table  cellpadding="1" cellpspacing="0"><tr><td bgcolor ="#006600">
<table border="0" width="150" cellpadding="2" bgcolor="#FFFFFF" nowrap>
<tr><td  bgcolor ="#006600"><font color="#FFFFFF"><b>Currency Rate</b></font></td></tr>
<tr><td>
<font class="bodynormal">
<strong>1 USD equivalent of </strong><br>
<table>
{foreach from=$currency item=currency key=cid}
<tr><td><small>{$currency.country}</small></td><td>
{$currency.currency}</td><td>{$currency.rate}</td></tr>
{/foreach}</font>
<tr><Td colspan="3"><hr><a href="index.php?m=currency">Currency Coverter</a></td>
<tr><td colspan="3" align="center"><small><b>Updated on {$lastupdate}</b></small></td></tr>
</table></td>
</tr>
</table>
</td></tr></table>
-->
