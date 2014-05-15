<form action="index.php?m=booking&op=booking2" method="post" name="booking2">
<table border="0" cellpadding="0" cellspacing="5" width="100%" class="yellowbg">
<tr><td>
<a href="index.php">{$lang.home}</a> >><a href="index.php?m=booking">{$lang.booking}</a> >{$lang.step_two} {$lang.booking_heading}</td>
</tr>
</table>
{$lang.booking_form_warning}
<table class="redbg" width="100%">
<tr><td>
<table width=99% class=lightyellow>
<tr><td>
<font class="error"> 
{validate field="fullname" criteria="notEmpty"  transform="trim" message=$lang.booking_error_fullname}
{validate field="phonenumber" criteria="notEmpty"  transform="trim" message=$lang.booking_error_phone}
{validate field="adult_fname" criteria="notEmpty"  transform="trim" message=$lang.booking_error_adultfname}
{validate field="adult_lname" criteria="notEmpty"  transform="trim" message=$lang.booking_error_adultlname}
{validate field="email" criteria="notEmpty"  transform="trim" message=$lang.booking_error_email}

{if $children!="0"}
{validate field="child_fname" criteria="notEmpty"  transform="trim" message=$lang.booking_error_childfname}
{validate field="child_lname" criteria="notEmpty"  transform="trim" message=$lang.booking_error_childlname}
{/if}
{if $infant!="0"}
{validate field="infant_fname" criteria="notEmpty"  transform="trim" message=$lang.booking_error_infantfname}
{validate field="infant_lname" criteria="notEmpty"  transform="trim" message=$lang.booking_error_infantlname}
{/if}

</font>
</td></tr>
<tr><td class=formtd>{$lang.booking_request} {$lang.step_two}</td></tr>
<tr><td class="tdpadding">

{if $adult <>"0"}
<fieldset><legend>{$lang.adults_name}</legend>
<table width=100%>
{section name="myLoop" start=0 loop=$adult}
<tr><td> {$lang.first_name} *: <input type="text" name="adult_fname[]" size="20" value="{$adult_fname[myLoop]|escape}"></td><td>{$lang.last_name} *: <input type="text" name="adult_lname[]" size="20" value="{$adult_lname[myLoop]|escape}"></td></tr>
{/section}
</table>
</fieldset>
{/if}
{if $children!="0"}
<fieldset><legend>{$lang.children_name}</legend>
<table width=100%>
{section name="myLoop" start=0 loop=$children}
<tr><td>{$lang.first_name} *: <input type="text" name="child_fname[]" size="20" value="{$child_fname[myLoop]|escape}"></td><td>{$lang.last_name} : <input type="text" name="child_lname[]" size="20" value="{$child_lname[myLoop]|escape}"></td></tr>
{/section}
</table>
</fieldset>
{/if}
{if $infant!="0"}
<fieldset><legend>{$lang.infant_name}</legend>
<table width=100%>
{section name="myLoop" start=0 loop=$infant}
<tr><td>{$lang.first_name} *: <input type="text" name="infant_fname[]" size="20" value="{$infant_fname[myLoop]|escape}"></td><td>{$lang.last_name} : <input type="text" name="infant_lname[]" size="20" value="{$infant_lname[myLoop]|escape}"></td></tr>
{/section}
</table>
</fieldset>
{/if}
<input type="hidden" name="origin" value="{$origin}">
<input type="hidden" name="destination" value="{$destination}">
<input type="hidden" name="departure_date" value="{$departure_date}">
<input type="hidden" name="returning_date" value="{$returning_date}">
<input type="hidden" name="type" value="{$type}">
<input type="hidden" name="class" value="{$class}">
<input type="hidden" name="airline" value="{$airline}">
<input type="hidden" name="adult" value="{$adult}">
<input type="hidden" name="children" value="{$children}">
<input type="hidden" name="infant" value="{$infant}">
<input type="hidden" name="product" value="{$product}">

<tr><td><fieldset><legend>{$lang.your_details}</legend>
<table width=100%>
<tr><td>{$lang.your_fullname} * <input type="text" name="fullname" size="20"  value="{$fullname|escape}"></td></tr>
<tr><td>{$lang.phone_number} * <input type="text" name="phonenumber" size="12" value="{$phonenumber|escape}"></td></tr>
<tr><td>{$lang.mobile_number} <input type="text" name="mobilenumber" size="12" value="{$mobilenumber|escape}"></td></tr>
<tr><td>{$lang.email_address} * <input type="text" name="email" size="20" value="{$email|escape}"></td></tr>

</table>
</fieldset>
</td></tr>


<tr><td><fieldset><legend>{$lang.additional_request}</legend>
<table><tr>
<td>{html_checkboxes name="product[]" options=$prod_chkbox selected=$product separator="<br />"}</td>
</tr>

<tr><td> <input type="checkbox" name="product[]" value="{$lang.concert}">{$lang.concert}</td></tr> 

</table>

</fieldset>
</td></tr>
<tr><td><fieldset><legend>{$lang.message}</legend>
<table><tr>
<tr><td valign="top" colspan=2><textarea name="msg" rows=4 cols=51></textarea>
</table>
</fieldset>
</td></tr>
<tr><td align="center"><input type="submit" value="{$lang.request}" name="Submit"><input type="Reset" value="{$lang.reset}"></td></tr>

</table>

</td></tr>
</table>
</form>