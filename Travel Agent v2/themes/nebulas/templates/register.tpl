<h2>Registration</h2>
<hr>
<form action="index.php?m=member&file=register" method="post" name="frm_registration">
(Fields that are marked with an * are compulsory)
<table width="100%" cellspacing="0" cellpadding="3">
<tr><td align="right">First Name</td><td><input type="text" name="fname" size="40" value="{$fname|escape}"> * <font class="error">{validate field="fname" criteria="notEmpty"  transform="trim" message="Please enter first name."}</font></td></tr>
<tr><td align="right">Last Name</td><td><input type="text" name="lname" size="40" value="{$lname|escape}"> * <font class="error">{validate field="lname" criteria="notEmpty"  transform="trim" message="Please enter last name."}</font></td></tr>
<tr><td align="right">Email Address</td><td><input type="text" name="email" size="30" value="{$email|escape}"> *<font class="error">{validate field="email" criteria="isEmail"  transform="trim" message="Please enter email address."}</font></td></tr>
<tr><td align="right">Repeat Email Address</td><td><input type="text" name="checkemail"size="30" value="{$checkemail|escape}">*<font class="error">{validate field="checkemail" criteria="isEmail"  transform="trim" message="Please repeat email address."}</font></td></tr>
<tr><td colspan="2" align="center"><font class="error">{validate field="email" criteria="isEqual" field2="checkemail" message="Email address and repeat email does not match" halt="yes"}</font></td><tr>
<tr><td align="right">Password</td><td><input type="password" name="password" size="30" value="{$password|escape}"> *<font class="error">{validate field="password" criteria="isPassword"  transform="trim" message="Please enter password.At least 4 characters."}</font></td></tr>
<tr><td align="right">Repeat Password</td><td><input type="password" name="checkpassword" size="30" value="{$checkpassword|escape}">*<font class="error">{validate field="checkpassword" criteria="isPassword"  transform="trim" message="Please repeat password."}</font></td></tr>
<tr><td colspan="2" align="center"><font class="error">{validate field="password" criteria="isEqual" field2="checkpassword" message="Password and repeat password does not match" halt="yes"}</font></td><tr>
<tr><td align="right">Phone</td><td><input type="text" name="phone" value="{$phone|escape}"> *<font class="error">{validate field="phone" criteria="notEmpty"  transform="trim" message="Please enter phone number."}</font></td></tr>
<tr><td align="right">Fax </td><td><input type="text" name="fax" value="{$fax|escape}"></td></tr>"
<tr><td align="right">Mobile</td><td><input type="text" name="mobile" value="{$mobile|escape}"></td></tr>
<tr><td align="right">Address</td><td><input type="text" name="addr" value="{$addr|escape}" size="23"> *<font class="error">{validate field="addr" criteria="notEmpty"  transform="trim" message="Please enter address."}</font></td></tr>
<tr><td align="right">Suburb</td><td><input type="text" name="suburb" value="{$suburb|escape}"></td></tr>
<tr><td align="right">City</td><td><input type="text" name="city" value="{$city|escape}"> *<font class="error">{validate field="city" criteria="notEmpty"  transform="trim" message="Please enter city."}</font></td></tr>
<tr>
<td></td><td><input  type="submit" value="Submit my registration" name="submit" tabindex="18"></td></tr>
</table>
</form>