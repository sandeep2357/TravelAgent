<form action="index.php?m=member&file=login" method="post" name="frm_member_login">
<h2>Member login</h2>
{if $no_user_found<>""}
<center><font color="#FF0000">Sorry,user name and password does not match against our record.</font></center>
{/if}
<fieldset>
<legend>Login</legend>
<table border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td>&nbsp;</td>
    <td><strong>Please Enter your Login Details</strong></td>
  </tr>
  <tr>
    <td align="right">Member Email</td>
    <td><input type="text" name="uemail" size="30" value="{$uemail|escape}"><br><small><font class="error">{validate field="uemail" criteria="isEmail"  transform="trim" message="* Please enter email address."}</font></small>
</td>
  </tr>
  <tr>
    <td align="right">Password</td>
    <td><input type="password" name="upass" size="30" value="{$upass|escape}"><br><small><font class="error">{validate field="upass" criteria="notEmpty"  transform="trim" message="* Please enter password."}</font></small></td>
  </tr>
   <tr>
      <td align="right">Security code</td>
      <td><img src="index.php?m=member&file=login&op=scode&code={$code}"></td>
  </tr>
    <tr>
          <td align="right">Type the above security code</td>
          <td><input type="text" name="scode" size="15"><br><small><font class="error">{validate field="scode" criteria="isValidCode"  transform="trim" message="* Please enter the above code."}</font></small></td>
    </tr>

  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="submit">&nbsp;<input type="Reset" value="Reset"></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td>Have your forgotten your password?  <a  href="index.php?m=member&file=lostpass">Click Here</a><br>
    Not a member yet?  <a  href="index.php?m=member&file=register">Join Now</a>
    </td>
  </tr>
</table>
</fieldset>
<input type="hidden" name="random_code" value="{$code}">
</form>
<br>