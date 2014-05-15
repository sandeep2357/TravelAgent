<table class="yellowbg" width="100%">
<tr><td><a href="index.php">{$lang.home}</a> >> <font class="red">{$lang.contact_us}></font></td></tr>
</table>
<table>
<Tr><td>
Our team of consultants will answer your questions and take care of your bookings. 
You can contact us with the form below.
</td></tr></table>

<table class="lightyellow" width="100%">
<tr><td>
<form action="index.php?m=contact" method="post">
<tr><td colspan="2" align="center"></td></tr>
<tr><td colspan="2">
<font class="error"> 
{validate field="uname" criteria="notEmpty"  message=$lang.contact_us_error_uname}
{validate field="uemail" criteria="notEmpty"  message=$lang.contact_us_error_email}
{validate field="subject" criteria="notEmpty"  message=$lang.contact_us_error_subject}
{validate field="message" criteria="notEmpty"  message=$lang.contact_us_error_msg}
</font>

</td></tr>
<tr><td align="right">Your Name</td><td><input type="text" name="uname" size="30" value="{$uname|escape}">
<tr><td align="right">Your Email Address</td><td><input type="text" name="uemail" size="30" value="{$uemail|escape}">
<tr><td align="right">Subject</td><td><input type="text" name="subject" size="30" value="{$subject|escape}">
<tr><td align="right" valign="top">Message</td><td><textarea name="message" rows="9" cols="44">{$message|escape}</textarea>
<tr><td >&nbsp;</td><td><input type="submit" name="submit" value="Send Message">
</table>
</form>
