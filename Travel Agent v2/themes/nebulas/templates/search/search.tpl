	<Table class="yellowbg" width="100%"><tr><td><a href="index.php">{$lang.home}</a> >> {$lang.search} {$lang.search_heading}</a>></td></tr></table>
	<table width="100%">
	<tr><td><font class="error">
	{validate field="origin" criteria="notEmpty"  transform="trim" message=$lang.booking_error_origin}
	{validate field="destination" criteria="notEmpty"  transform="trim" message=$lang.booking_error_destination}
	</font>
	<tr><td>
	<form action="index.php?m=search" method="post" name="fare_search">
	<table class="whitebg" width="100%">
	<tr><td align="right">{$lang.origin}*</td>
		<td>
		<select name="origin">
		<option value="">{$lang.select_origin}</option>
		{html_options options=$origin_opt selected=$origin}
		</select>

		</td></tr>
	<tr><td align="right">{$lang.destination} *</td>
	<td>
	<select name="destination">
	<option value="">{$lang.select_destination}</option>
	{html_options options=$destination_opt selected=$destination} 
	</select>
	</td>	
	<tr><td align="right">{$lang.departure_date}/s</td><td><input type="text" name="departure" value="{$departure|escape}" maxlength=10 size=10>  <a href="javascript:void(window.open( 'calendar.php?departure&formName=fare_search', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a></tr>
		<tr><td align="right"> {$lang.search_faretype}</td>
	<td><select name="faretype">
	<option value="">{$lang.search_any}</option>
	{html_options options=$type_opt selected=$faretype} 
	</select>

	</td></tr>
	<tr><td align="right">{$lang.fare_class}</td>
	<td><select name="class">
	<option value="">{$lang.any_class}</option>
	{html_options options=$class_opt selected=$class} 
	</select>

	</td></tr>
	<tr><td align="right">{$lang.airline}</td>
	
	<td><select name="airline">
	<option value="0" >{$lang.search_any}</option>
	<option value="">{$lang.all_available}</option>
	{html_options options=$airline_opt selected=$airline} 

	</select>

	</td></tr>
	<tr><td colspan=2 align=center>
	<br>
	<input type="submit" value="{$lang.search_searchbtn}"><input type="reset" value="Reset">
	</td>
	</tr>
	</table>
	</td></tr></table>