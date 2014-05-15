<table class="yellowbg" width="100%">
<tr class="title"><td><a href="index.php">{$lang.home}</a> >>Flight Information </td></td></tr>
</table>
<table width="100%" class="package">
<tr><td>
<table width="100%"><tr><td>
<form>
<Table width="100%"><tr class="title"><td><h2>{$flight.flight_title}</h2>Flight Information at auckland airport.</td><td align="right">Please select option
<select name="act"  onChange='OnChange(this.form.act,"index.php?m=flightinformation&act=");'>";
{html_options options=$act_opt selected=$act}
</select>
</td>
</tr>
<tr><td colspan="2">{$flight.flight_content}</td></tr>
</table>
<hr></form>
</td></tr>
</table>
</td></table>