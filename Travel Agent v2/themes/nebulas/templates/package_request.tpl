<Table class="yellowbg" width="100%"><tr><td><a href="index.php">{$lang.home}</a>>> <a href=index.php?m=package>{$lang.packages}</a> >><a href="index.php?m=package&file=packagedetails&id={$package.package_id}">{$package.package_name}</a> booking request form</td></tr></table>
<form  action="index.php?m=package&file=package_request&id={$package.package_id}" method="post" name="package_request">
<table width="100%" class="redbg">
<tr><td>
<table class="lightyellow" width="100%"><tr><td>
<fieldset>
<legend>{$lang.booking_enquiry}</legend>
<table>
<tr><td>{$lang.first_name}: (*)</td><td><input type="text" name="fname" size=30 value="{$fname|escape}"> <font class=error>{validate  field="fname" criteria="notEmpty" message="Please enter first name"}</font></td></tr>   
<tr><td>{$lang.last_name}: (*)</td><td><input type="text" name="lname" size=30 value="{$lname|escape}">  <font class=error>{validate field="lname" criteria="notEmpty" message="Please enter last name"}</font></td></tr>  
<tr><td>{$lang.email}: (*)</td><td><input type="text" name="email" value="{$email|escape}">  <font class=error>{validate  field="email" criteria="notEmpty" message="Please enter email address"} {validate form="package_request" field="email" criteria="isEmail" message="Email address is invalid"}</font></td></tr>   
<tr><td>{$lang.phone_number}: (*) </td><td><input type="text" name="phone" value="{$phone|escape}">  <font class=error>{validate field="phone" criteria="notEmpty" message="Please enter phone number"}</font></td></tr>
<tr><td>{$lang.when_do_u_want_to_travelling}:</td><td><input type="text" name="date1" maxlength=10 size=10 onFocus=this.blur()>  <a href="javascript:void(window.open( 'calendar.php?date1&formName=package_request', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a></td></tr>        
<tr><td>{$lang.no_of_people_travelling}: </td><td><input type="text" name="nopeople" size=3></td></tr>
<tr><td valign="top">{$lang.additional_request}</td><td align="right">
<table><tr>
<td><input type="checkbox" name="product[]" value="{$lang.rental_cars}">{$lang.rental_cars}</td>
<td><input type="checkbox" name="product[]" value="{$lang.cruises}">{$lang.cruises}</td>
<td> <input type="checkbox" name="product[]" value="{$lang.coach_tours}">{$lang.coach_tours}</td> 
</tr><tr>
<td> <input type="checkbox" name="product[]" value="{$lang.sightseeing}">{$lang.sightseeing}</td> 
<td> <input type="checkbox" name="product[]" value="{$lang.rail}">{$lang.rail}</td></tr> 
<tr><td> <input type="checkbox" name="product[]" value="{$lang.concert}">{$lang.concert}</td></tr> 
</table>
</td></tr>
<tr><td valign="top">{$lang.message}</td><td><textarea name="msg" rows="4" cols="51">{$msg|escape}</textarea>
<tr><td colspan="2" align="center"><input type="submit" value="{$lang.send_request}"></td></tr>
</table>
</form>
</td></tr>
</fieldset>
</table>

</td></tr></table>
