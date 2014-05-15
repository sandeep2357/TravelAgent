<h2>Change Password</h2>
<hr>
<form action="index.php?m=member&op=password" method="post" name="frm_password">(Fields that are marked with an * are compulsory)
{if $old_password<>""}
<center><font color="#FF0000">Your old password does not match against our record.</font></center>
{/if}

<table width="100%" cellspacing="0" cellpadding="3">
<tr><td align="right">Your old password</td><td><input type="password" name="oldpass" size="30" value="{$oldpass|escape}"> *<font class="error">{validate field="oldpass" criteria="isPassword"  transform="trim" message="Please enter your old password."}</font></td></tr>
<tr><td align="right">New Password</td><td><input type="password" name="password" size="30" value="{$password|escape}"> *<font class="error">{validate field="password" criteria="isPassword"  transform="trim" message="Please enter password.At least 4 characters."}</font></td></tr>
<tr><td align="right">Repeat New Password</td><td><input type="password" name="checkpassword" size="30" value="{$checkpassword|escape}"> *<font class="error">{validate field="checkpassword" criteria="isPassword"  transform="trim" message="Please enter repeat password."}</font></td></tr>
<tr><td colspan="2" align="center"><font class="error">{validate field="password" criteria="isEqual" field2="checkpassword" message="Password and repeat password does not match" halt="yes"}</font></td><tr>
<tr>
<td></td><td><input  type="submit" value="Update password" name="submit"></td></tr>
</table>
</form>