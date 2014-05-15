<form action="admin.php?m=admin&file=login" method="post" name="frm_adminlogin">
<h2>Admin Login</h2>
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
    <td align="right">Admin Email</td>
    <td><input type="text" name="name" size="30" value="{$name|escape}"><br><small><font class="error">{validate field="name" criteria="notEmpty"  transform="trim" message="* Please enter name."}</font></small>
</td>
  </tr>
  <tr>
    <td align="right">Password</td>
    <td><input type="password" name="pass" size="30" value="{$pass|escape}"><br><small><font class="error">{validate field="pass" criteria="notEmpty"  transform="trim" message="* Please enter password."}</font></small></td>
  </tr>
   <tr>
      <td align="right">Security code</td>
      <td><img src="admin.php?m=admin&file=login&op=scode&code={$code}"></td>
  </tr>
  <tr>
        <td align="right">Type the above security code</td>
        <td><input type="text" name="scode" size="15"><br><small><font class="error">{validate field="scode" criteria="isValidCode"  transform="trim" message="* Please enter the above code."}</font></small></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="submit">&nbsp;<input type="Reset" value="Reset"></td>
  </tr>
 </table>
</fieldset>
<input type="hidden" name="random_code" value="{$code}">
</form>
<br>