<table class="yellowbg" width="100%">
<tr><td><a href="index.php">{$lang.home}</a> >>{$lang.fare_details} >> {if $fare.fare_title}{$fare.fare_title}{else}{$fare.origin_name} » {$fare.destination_name}{/if}</td></tr>
</table>
<table width="100%" class="redbg">
<tr><td>

<table class="lightyellow" width="100%">
	<tr><td align="center"><img src=images/print.gif border=0 align=absmiddle> <a href="index.php?m=print" target="_blank">{$lang.print}</a></td>
	<td><img src=images/mail.gif border=0 align=absmiddle> <a href="index.php?m=fare&file=friend&id={$fare.fare_id}">{$lang.send_to_friend}</a> </td>
	<td><img src=images/book.gif border=0 align=absmiddle> <a href=index.php?m=fare&file=booking_request&id={$fare.fare_id}>{$lang.request_enquiry}</a> </td>
	</tr>
	{if $phone<>""}
	<tr>
	<td colspan="3" align="center"><br><h2>{$phone}</h2></td>
	{/if}
	</tr>
</table>

<!--printstart-->
<table class="whitebg" width="100%">
	<tr><td>
	<fieldset>
	<legend>{$lang.fare_summary}</legend>
	<table width="100%">
	<tr><td>
	<table width="100%" class="lightyellow" cellspacing="0">
	<tr><td>{$lang.fare_id}</td><td>{$fare.fare_id}</td></tr>
	<tr><td>{$lang.airline}</td><td valign="absmiddle">{$fare.airline_name}{if $fare.airline_logo}<img src="images/airlines/{$fare.airline_logo}" border="0" width="40" align="absmiddle">{/if}</td></tr>
	<tr><td>{$lang.fare_class}</td><td>{$fare.class_name}</td></tr>
	<tr><td>{$lang.price}</td><td>${$fare.fare_adultfare}</td></tr>
	<tr><td>{$lang.travel_length}</td><td>{$fare.fare_dept_start|date_format:"%d %b %Y"}-{$fare.fare_dept_end|date_format:"%d %b %Y"}</td></tr>
	<tr><td>Origin</td><td>{$fare.origin_name}</td></tr>
	<tr><td>Destination</td><td>{$fare.destination_name}</td></tr>
	<tr><td>{$lang.minimum_stay}</td><td>{$fare.fare_stay_min}</td></tr>
	<tr><td>{$lang.maximum_stay}</td><td>{$fare.fare_stay_max}</td></tr>
	{if $restriction<>""}
	<tr><td>{$lang.restriction}</td><td>{$restriction}</td></tr>
	{/if}
	</tr>
	</table>
	</td>
	</tr>
	</table>
	</fieldset>
</td></tr></table>
{if $fare.fare_note<>""}
<table class="whitebg" width="100%">
	<tr><td>
	<fieldset>
	<legend>{$lang.additional_information}</legend>
	<table width="100%">
	<tr><td>{$fare.fare_note|nl2br}</td></tr>
	
	</table>
	</fieldset>
		</td>
		</tr>
	</table>
{/if}	
</td></tr></table>
{if $smarty.session.admin}<a href="admin.php?op=editfare&id={$fare.fare_id}">Edit</a>{/if}

<!--printend-->
