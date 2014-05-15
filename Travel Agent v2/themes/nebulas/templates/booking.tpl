<form action="index.php?m=booking" method="post" name="booking">
<table border="0" cellpadding="0" cellspacing="5" width="100%" class="yellowbg">
<tr><td>
<a href="index.php">{$lang.home}</a> >> {$lang.booking} > {$lang.step_one}</th>
</tr>
</table>
<table class="redbg" width="100%"><tr><td>
<table width=100% class=lightyellow>
<tr><td><font class="error"> 
{validate field="origin" criteria="notEmpty"  message=$lang.booking_error_origin}
{validate field="departure_date" criteria="notEmpty"  message=$lang.booking_error_departure_date}
{validate field="destination" criteria="notEmpty"  message=$lang.booking_error_destination}
</font>
</td></tr>
<tr><td class=formtd>{$lang.booking_request}{$lang.step_one}</td></tr>
<tr><td class="tdpadding">

<table width="100%"><tr><td>{$lang.from} *</td><td>
<select name="origin" >
<option value="">{$lang.select_origin}</option>
{html_options options=$origin_opt selected=$origin}
</select>

</td><td align="right">{$lang.departure_date} *</td><td>
<input type="text" name="departure_date" maxlength=10 size=10 onFocus=this.blur()  value="{$departure_date|escape}"><a href="javascript:void(window.open('calendar.php?departure_date&formName=booking', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a>
<td></tr>
<tr><td colspan=3></td></tr>
<tr><td>{$lang.to} *</td><td>
<select name="destination">
<option value="">{$lang.select_destination}</option>
{html_options options=$destination_opt selected=$destination} 
</select>
</td><td align=right>{$lang.date_of_return}</td><td><input type="text" name="returning_date" value="{$returning_date|escape}" maxlength=10 size=10 onFocus=this.blur()><a href="javascript:void(window.open('calendar.php?returning_date&formName=booking', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a></td>
</tr>
<tr><td colspan=3></td></tr>

<tr><td>{$lang.fare_class}</td>
<td>
<select name="class">
<option value="">{$lang.any_class}</option>
{html_options options=$class_opt selected=$class} 
</select>
</td><td align="right">{$lang.airline}</td><td>

<select name="airline">
<option value="">{$lang.all_available}</option>
{html_options options=$airline_opt selected=$airline} 

</select>
</td>
</tr>
<tr><td colspan=3></td></tr>
<tr><td>{$lang.adult}</td><td>
<select name="adult">
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
<option value=6>6</option>
<option value=7>7</option>
<option value=8>8</option>
<option value=9>9</option>
</select>
&nbsp;{$lang.children}
<select name="children">
<option value=0>{$lang.nill}</option>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
<option value=6>6</option>
<option value=7>7</option>
<option value=8>8</option>
<option value=9>9</option>
</select>
</td>
<td>{$lang.infant}
<select name="infant">
<option value=0>{$lang.nill}</option>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
<option value=6>6</option>
<option value=7>7</option>
<option value=8>8</option>
<option value=9>9</option>
</select>
</td>
</tr>
<tr><td>{$lang.booking_type}</td><td><input type="radio" checked name="btype" value="0">{$lang.oneway}<input type="radio" name="btype" value="1">{$lang.return}</tr>
<tr><td colspan=3></td></tr>

<tr><td colspan=2 align="center"><input type="submit" value="{$lang.booking_btncontinue}>>"></td></tr>
</table></td></tr>
</table>
</td></tr></table>

</form>