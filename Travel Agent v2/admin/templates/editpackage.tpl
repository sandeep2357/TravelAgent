<form action="admin.php?op=editpackage" name="frm_editpackage" method="post" enctype="multipart/form-data">
<table align=center width=100% bgcolor=#FFCC66>
<tr><td>
<fieldset>
<legend>Edit package</legend>
<table bgcolor=#FFCC66 width=100%>
<tr><td align="right" valign="top">Package Continent</td><td>
<select name="continent">
<option value=>--Select--</option>
{html_options options=$continent_opt selected=$continent}
</select>
<br>
<small><font color=red>{validate  field="continent" criteria="notEmpty" message="Please select continent"}</font></small>

</td></tr>

<tr><td align="right" align="right" valign="top">Package name *</td><td><input type="text" name="name" size="40" value="{$name|escape}">(Do not enter price)
<br>
<small><font color=red>{validate  field="name" criteria="notEmpty" message="Please enter package name."}</font></small>
</td></tr>
<tr><td align="right" valign="top">Price *</td><td><input type="text" name="price" value="{$price|escape}">(ie.2360)
<br>
<small><font color=red>{validate  field="price" criteria="notEmpty" message="Please enter price."}</font></small>

</td></tr>
<tr><td valign="top" align="right" valign="top">Description </td><td><textarea name="description" rows="5" cols="61">{$description|escape}</textarea><br></td></tr>
<tr><td valign="top" align="right" valign="top">Make it active ?</td><td>

{html_radios name="active" options=$opt_radio selected=$active separator="<br />"}
</td></tr>
<tr><td align="right" valign="top">Expire *</td><td><input type=text name="expire" maxlength=10 size=10 value="{$expire|escape}" onFocus=this.blur()>  <a href="javascript:void(window.open( 'calendar.php?expire&formName=frm_editpackage', '', 'width=200,height=210,top=120,left=120' ))"><img src="images/calender.gif" border=0 align=absmiddle></a>
<br>
<small><font color=red>{validate  field="expire" criteria="notEmpty" message="Please enter expiry date."}</font></small>

</td></tr>
<tr><td align="right">Photo</td><td><input type="file" name="filename">(<small>It's appear right hand site of details page)</small></td></tr>
<tr><td align="right">File</td><td><input type="file" name="packagefile"> {if $package.package_file_size<>""}<a href="admin.php?op=viewPackageFile&id={$package.package_id}">{$package.package_file_name}</a>{/if}</td><td>


<tr><td></td><td><input type="submit" value="Update packages"><input type="submit" value="Remove packages" name="del"></td</tr>
</table>
</fieldset>
</td></tr>
</table>
<input type="hidden" name="id" value="{$id}">
</form>