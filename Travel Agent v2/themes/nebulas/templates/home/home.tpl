<table width="100%">
<tr><td>
<p class="title">Welcome to Our website.</p>
<table height="1" width="100%">
<Tr><Td  background="themes/nebulas/images/back-line.jpg" height="1" nowrap>
</td></tr></table>

<p align="justify">
We offer a comprehensive range of holidays and great specials too.
 We specialise in airfares to south asia,middle east,europe  and other destinations.
 </p>
 
 <table height="100%" cellSpacing="0" cellPadding="0" width="493" border="0" id="table1">
 <tr>
 	<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px; padding: 7px; background-repeat: no-repeat; background-position: 50% top" background="themes/nebulas/images/back-fl.jpg" height="167">
 	<a style="font-family: Tahoma; font-size: 11px; color: 362C1E" href="#">
 	<img src="themes/nebulas/images/{$randompix}" style="border: 0 none"></a></td>
 </tr>
 <tr>
 	<td style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px">
 	<img height="7" src="themes/nebulas/images/spacer.gif" width="1" style="border: 0 none"></td>
 </tr>
 </table>
 
 <!--special start-->
 <table height="100%" cellSpacing="0" cellPadding="0" width="100%" border="0" id="table1">
  <tr>
  	<td valign="top" style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px; padding: 7px; background-repeat: no-repeat; background-position: 50% top" background="themes/nebulas/images/back-fl.jpg" height="167">
  
	<font class="title">{$lang.specials}</font>
<table height="1" width="100%">
<Tr><Td  background="themes/nebulas/images/back-line.jpg" height="1" nowrap>
</td></tr></table>


	<table  cellspacing="0" width="100%">
	<tr class="title"><td >Fare</td><td>{$lang.prices}</td><td>{$lang.purchase_by}</td><td>{$lang.more}</td></tr>
	{section name="idx" loop="$special"}
		<tr><td>{$special[idx].fare_title} </td><td class="redprice">${$special[idx].fare_adultfare}</td><td>{$special[idx].fare_purchaseby|date_format:"%d %b %Y"}</td><td><a href="index.php?m=fare&id={$special[idx].fare_id}">{$lang.click_here}</a><td></tr>
	{/section}
	</table>
	</td></tr></table>
	<br>
</td>
  </tr>
   </table>
<!-- special finished-->



 <table height="100%" cellSpacing="0" cellPadding="0" width="100%" border="0" id="table1">
  <tr>
  	<td valign="top" style="font-family: Tahoma; font-size: 11px; color: 362C1E; line-height: 12px; padding: 7px; background-repeat: no-repeat; background-position: 50% top" background="themes/nebulas/images/back-fl.jpg" height="167">
  

 
<table height="1" width="100%">
<tr><Td><font class="title">{$lang.hot_packages}</font></td><td align="right"><font class="title">From</font></td></tr>
<Tr><td background="themes/nebulas/images/back-line.jpg" height="1" nowrap></td><td background="themes/nebulas/images/back-line.jpg" height="1"></td></tr>
</table>

<table  width="100%">
{assign var="i" value="1"} 
{section name="idx" loop="$package"}
	<tr><td><img src="themes/nebulas/images/new.jpg" align="absmiddle">&nbsp;<a href="index.php?m=package&file=packagedetails&id={$package[idx].package_id}">{$package[idx].package_name}</a></td><td align="right" class="redprice">${$package[idx].package_cost}</td></tr>

{/section}
</tr>
</table>


</td>
  </tr>
   </table>
