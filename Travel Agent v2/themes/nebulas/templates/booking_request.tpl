<Table class="yellowbg" width="100%"><tr><td><a href="index.php">{$lang.home}</a>>><a href=index.php?m=search>{$lang.fare}</a> >>{if $fare.fare_title}{$fare.fare_title}{else}{$fare.origin_name} » {$fare.destination_name} {$fare.fare_adultfare}{/if}</td></tr></table>
<form action="index.php?m=fare&file=booking_request" method="post" name="booking_request">

<table width="100%" class="redbg">
<tr><td>
<table class="lightyellow" width="100%"><tr><td>
<fieldset>
<legend>Booking Enquiry</legend>
<table>
<tr><td>First Name: (*)</td><td><input type="text" name="fname" size=30 value="{$fname|escape}"> <font class=error>{validate field="fname" criteria="notEmpty" message="Please enter first name"}</font></td></tr>   
<tr><td>Last/Family Name: (*)</td><td><input type="text" name="lname" size=30 value="{$lname|escape}">  <font class=error>{validate field="lname" criteria="notEmpty" message="Please enter last name"}</font></td></tr>  
<tr><td>Email: (*)</td><td><input type="text" name="email" value="{$email|escape}">  <font class=error>{validate field="email" criteria="notEmpty" message="Please enter email address"} {validate field="email" criteria="isEmail" message="Email address is invalid"}</font></td></tr>   
<tr><td>Phone No: (*) </td><td><input type="text" name="phone" value="{$phone|escape}">  <font class=error>{validate field="phone" criteria="notEmpty" message="Please enter phone number"}</font></td></tr>
<tr><td>When do you plan to travel?:</td><td><input type="text" name="date1" maxlength=10 size=10 onFocus=this.blur()>  <a href="javascript:void(window.open( 'calendar.php?date1&formName=booking_request', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a></td></tr>        
<tr><td>Number of People travelling: </td><td><input type="text" name="nopeople" size=3></td></tr>
<tr><td valign="top">Additional Request</td><td align="right">
<table><tr>
<td><input type="checkbox" name="product[]" value="Rental Cars"> Rental Cars</td>
<td><input type="checkbox" name="product[]" value="Cruises"> Cruises</td>
<td> <input type="checkbox" name="product[]" value="Coach Tours">Coach Tours</td> 
</tr><tr>
<td> <input type="checkbox" name="product[]" value="Sightseeing Options">Sightseeing Options</td> 
<td> <input type="checkbox" name="product[]" value="Rail Options">Rail Options</td></tr> 
<tr><td> <input type="checkbox" name="product[]" value="Concerts and Shows">Concerts and Shows</td></tr> 
</table>
</td></tr>
<tr><td valign="top">Message</td><td><textarea name="msg" rows=4 cols=51></textarea>
<tr><td colspan="2" align="center"><input type="submit" value="Send Request"></td></tr>
</table>
<input type="hidden" name="id" value="{$id}">
</form>
</td></tr>
</fieldset>
</table>

</td></tr></table>
