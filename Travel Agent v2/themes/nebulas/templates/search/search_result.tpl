
<table class=yellowbg width=100%>
<tr><td>{$lang.found} {$found} {$lang.fares} .{$lang.displaying}: {$starting_no}-{$end_count} » {$lang.page} {$currentpage}</td><td> {$page_link}</td></tr>
</table>
{if $norecord!=""}
<table  class="redbg" width="100%"><tr><td align="center">
	<table  class="whitebg" width="100%"><tr><td align="center"><b>{$lang.no_fare_found} <a href="index.php?m=search">{$lang.try_again} ?</a></b></td></tr></table>
</td></tr></table>
{/if}
<table width=100%><tr><td>
<Table width="60%"><tr  class="title"><td>{$lang.origin} :&nbsp;&nbsp;{$originName}</td><td align="right"> {$lang.destination}:&nbsp;&nbsp;{$destinationName}</td></tr></table>

<table width=100% class="whitebg">
<tr><td>
<fieldset>
<legend>{$lang.airline_fares}</legend>
<table border=0 cellpadding=4 cellspacing=0 bgcolor=#FFFFFF width=100%>
<tr class="yellowbgbold"><td>{$lang.airline}</td><td>{$lang.price}</td><td>{$lang.purchaseby}</td><td>{$lang.travel_period}</td><td>{$lang.details}</td></tr>
{foreach from=$fareinfo item=fare key=fid}
<tr bgcolor="{cycle values="#eeeeee,#dddddd"}"><td>{$fare.airline}</td><td>${$fare.fare_adultfare}</td><td>{$fare.fare_purchaseby|date_format:"%d %b %Y"}</td><td>{$fare.fare_dept_start|date_format:"%d %b %Y"}--{$fare.fare_dept_end|date_format:"%d %b %Y"}</td><td><a href="index.php?m=fare&id={$fare.fare_id}&origin={$originName}&destination={$destinationName}">{$lang.bookingdetails}</a></td></tr>
{/foreach}
</table>
</fieldset>
</td></tr>
</table>
</td></tr></table>
