<table class="redbg" width="100%"><tr><td>
<table class="whitebg" width="100%">
<tr><td class="title">Package {$package.package_name} - {$package.package_cost}</td></tr>
<tr><td>Email to a freind. Please fill in the form correctly.<hr><td>
</td>
</tr>
</table>

<table class="whitebg" width="100%">
<tr><td>
<fieldset>
<form method="post" action="index.php?m=package&file=friend" name="friend_package">
<input type="hidden" name="id" value="{$smarty.request.id}">
<table width="100%">
<tr><td align="right" valign="top">Your Name</td><td><input type="text" name="uname" size="35" value="{$uname|escape}">
<br><small><font color="Red">{validate field="uname" criteria="notEmpty" transform="trim" message="Please enter your name"}</font></small>
</td></tr>
<tr><td align="right">Your email address</td><td><input type="text" name="uemail" size="25" value="{$uemail|escape}">
<br><small><font color="Red">{validate field="uemail" criteria="notEmpty"  message="Please enter your email address"}</font></small>
</td></tr>
<tr><td align="right">Retype your email address</td><td><input type="text" name="uemail1" size="25" "value="{$uemail1|escape}">
<br><small>
<font color="Red">{validate field="uemail1" criteria="notEmpty"  message="Please retype your email address"}</font>
</small>
</td></tr>
<tr><td align="right">Friend's email address</td><td><input type="text" name="email2" size="30" value="{$email2|escape}">
<br><small><font color="Red">{validate field="email2" criteria="notEmpty"  message="Please enter your friend's email address"}</font></small>
</td></tr>
<tr><td align="right">Retype friend's email address</td><td><input type="text" name="email3" size="30" value="{$email3|escape}">
<br><small><font color="Red">{validate field="email3" criteria="notEmpty"  message="Please retype your friend's email address"}</font></small>
</td></tr>

<tr><td colspan="2" align="center" ><input type="submit" value="Send now !"></td></tr>
</table>
</form>
</fieldset>
</td></tr></table>
</tr></td></table>