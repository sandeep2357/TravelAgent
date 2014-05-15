<form method="post" action="admin.php?op=editfare" name="frm_editfare">
<table align=center width=100% bgcolor=#FFCC66>
<tr><td>
<fieldset>
<legend>Edit Fare</legend>
<table width="100%">
<tr><td align="right">Airline *</td>
<td><select name=airline>
<option value="">--Select airline--</option>
{html_options options=$airline_opt selected=$airline }
</option>
</select>
<small><font color=red>{validate  field="airline" criteria="notEmpty" message="Please select airline"}</font></small>

</td></tr>
<tr><td align="right">Fare Title *</td><td><input type="text" name="title" size="31" value="{$title|escape}"> <small><font color=red>{validate  field="title" criteria="notEmpty" message="Please enter title"}</font></small>
</td></tr>
<tr><td align="right">Is this Special ?</td><td>
{html_radios name=special options=$special_opt selected=$special}
</td></tr>
<tr><td align="right">Make this fare active ?</td><td>
{html_radios name=active options=$active_opt selected=$active}

</td></tr>
<tr><td align="right">Adult fare *</td><td><input type="text" name="adultfare" value="{$adultfare|escape}">(ie.2300) <small><font color=red>{validate  field="adultfare" criteria="notEmpty" message="Please enter adultfare."}</font></small>
</td></tr>
<tr><td align="right">Child fare</td><td><input type=text name="child" value="{$child|escape}">(ie,1200)</td></tr>
<tr><td align="right">Infant fare</td><td><input type=text name="infant" value="{$infant|escape}">(ie.700)</td></tr>
<tr><td align="right">Fare Type *</td>
<td><select name="faretype">
<option value="">--Select Type--</option>
{html_options options=$type_opt selected=$faretype}

</select>
<small><font color=red>{validate  field="faretype" criteria="notEmpty" message="Please select fare type"}</font></small>

</td></tr>
<tr><td align="right">Class *</td>
<td><select name="travelclass">
<option value="">--Select Class--</option>
{html_options options=$class_opt selected=$travelclass}

</option>
</select><small><font color=red>{validate  field="travelclass" criteria="notEmpty" message="Please select class"}</font></small>

</td></tr>

<tr><td align="right">Departure first*</td><td><input type="text" value="{$date1|escape}" name="date1" maxlength=10 size=10 onFocus=this.blur()>  <a href="javascript:void(window.open( 'calendar.php?date1&formName=frm_editfare', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a>
<small><font color=red>{validate  field="date1" criteria="notEmpty" message="Please enter departure first date."}</font></small>

</td></tr>
<tr><td align="right">Departure last*</td><td><input type=text name=date2  value="{$date2|escape}" maxlength=10 size=10 onFocus=this.blur()>  <a href="javascript:void(window.open( 'calendar.php?date2&formName=frm_editfare', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a>
<small><font color=red>{validate  field="date2" criteria="notEmpty" message="Please enter departure last date."}</font></small>

</td></tr>
<tr><td align="right">Stay Min</td><td><input type="text" name="mindate" value="{$mindate|escape}"> (ie. 1M or 1D)</td></tr>
<tr><td align="right">Stay Max</td><td><input type="text" name="maxdate" value="{$maxdate|escape}">(ie. 1M or 1D)</td></tr>
<tr><td align="right">Restricted Fare Type</td>
<td><select name="restriction">
<option value="">--Select--</option>
{html_options options=$restriction_opt selected=$restriction}

</option>
</select>
</td></tr>
<tr><td align="right">Purchase by date * </td><td><input type=text name=purchaseby value="{$purchaseby|escape}" maxlength=10 size=10 onFocus=this.blur()>  <a href="javascript:void(window.open( 'calendar.php?purchaseby&formName=frm_editfare', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a>
<small><font color=red>{validate  field="purchaseby" criteria="notEmpty" message="Please enter purchaseby"}</font></small>

</td></tr>
<tr><td align="right" valign="top">Origin *</td>
<td>
{html_checkboxes name="origin" options=$origin_opt selected=$origin separator="<br />"}

<small><font color=red>{validate  field="origin" criteria="notEmpty" message="Please select origin."}</font></small>

</td></tr>

<tr><td align="right">Destination *</td>
<td><select name="destination">
<option value="">--Select--</option>

{html_options options=$destination_opt selected=$destination}
</option>
</select>
<small><font color=red>{validate  field="destination" criteria="notEmpty" message="Please select destination."}</font></small>

</td></tr>
<tr><td valign="top" align="right">Fare Note</td><td><textarea rows=8 cols=51 wrap=virutal name="note">{$note|escape}</textarea></td></tr>
<tr><td></td><td><input type="submit" value="Update Fare">&nbsp; &nbsp;<input type="submit" value="Remove fare" name="del"></td></tr>
</table>
</td></tr>
</fieldset>
<input type="hidden" name="id" value="{$id}">

</table>
</form>