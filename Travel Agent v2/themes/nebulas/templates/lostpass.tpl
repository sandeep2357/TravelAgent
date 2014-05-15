<form action="index.php?m=member&file=lostpass" method="post"  name="frm_lostpass">
<fieldset>
<legend>Reset password</legend>
{if $no_user_found }
<p class="error">Sorry,we did not find any user by email address "{$uemail}"</p> 
{/if}
<table border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td align="right">Member Email</td>
    <td><input type="text" name="uemail" size="30" value="{$uemail|escape}"><font class="error">{validate field="uemail" criteria="isEmail"  transform="trim" message="* Please enter email address."}</font>
</td>
</tr>
 <tr>
    <td align="right">Your new password<br><strong><small>(Minimum 4 characters)</small></strong></td>
    <td><input type="password" name="upass" size="30" value="{$upass|escape}"><font class="error">{validate field="upass" criteria="isPassword"  transform="trim" message="* Please enter password."}</font></td>
  </tr>
 <tr>
    <td align="right">Re-enter password</td>
    <td><input type="password" name="ucheckpass" size="30" value="{$ucheckpass|escape}"><font class="error">{validate field="ucheckpass" criteria="isPassword"  transform="trim" message="* Please Re-enter password."}</font></td>
  </tr>

<tr><td colspan="2" align="center"><input type="submit" value="Request">&nbsp;<input type="reset" value="Reset form"></td></tr>
<tr>
    <td >&nbsp;</td>
    <td>Not a member yet?  <a  href="index.php?m=member&file=register">Join Now</a>
    </td>
  </tr>
</table>
</fieldset>
</form>