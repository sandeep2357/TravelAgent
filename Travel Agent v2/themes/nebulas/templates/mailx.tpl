<table class="redbg" width="100%"><tr><td>
<table class="yellowbg" width="100%">
<tr><td>

<table>
<tr>Email to freind <td>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table>


<table class="redbg" width="100%"><tr><td>
<table class="whitebg" width="100%">
<tr><td>
<fieldset>
<form method="post" action="index.php?m=package&file=friend" name="friend_package">
<input type="hidden" name="msg" value="Your friend has sent the link to view it.">
<input type="hidden" name="subject" value=":: Travel information">
<input type="hidden" name="id" value="{$smarty.request.id}">
<table width="100%">
<tr><td><font color="Red">{validate field="uname" criteria="notEmpty" transform="trim" message="Please enter your name"}</font><br>Your Name</td>
<td><input type="text" name="uname" size="20" value="{$uname|escape}"></td></tr>
<tr><td><font color="Red">{validate field="uemail" criteria="notEmpty"  message="Please enter your email address"}</font><br>Your email address<td><input type="text" name="uemail" size="25" value="{$uemail|escape}"></td></tr>
<tr><td><font color="Red">{validate field="uemail1" criteria="notEmpty"  message="Please retype your email address"}</font><br>Retype your email address<td><input type="text" name="uemail1" size="25" "value="{$uemail1|escape}"></td></tr>
<tr><td><font color="Red">{validate field="email2" criteria="notEmpty"  message="Please enter your friend's email address"}</font><br>Friend email address</td><td><input type="text" name="email2" size="30" value="{$email2|escape}"></td></tr>
<tr><td><font color="Red">{validate field="email3" criteria="notEmpty"  message="Please retype your friend's email address"}</font><br>Retype friend's email address</td><td><input type="text" name="email3" size="30" value="{$email3|escape}"></td></tr>

<tr><td colspan="2" align="center" ><input type="submit" value="Send"></td></tr>
</table>
</form>
</fieldset>
</td></tr></table>
</tr></td></table>