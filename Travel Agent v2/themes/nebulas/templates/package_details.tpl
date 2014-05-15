<table class="yellowbg" width="100%">
<tr><td><a href="index.php">{$lang.home}</a> >> <a href="index.php?m=package">{$lang.packages}</a> >> {$package.package_name}</td><td>${$package.package_cost}</td></tr>
</table>

<table width=100% class="whitebg">
<tr><td>
<table class="lightyellow" width="100%">
	<tr><td align="center"><img src=images/print.gif border=0 align=absmiddle> <a href="index.php?m=print" target="_blank">{$lang.print}</a></td>
	<td><img src=images/mail.gif border=0 align=absmiddle> <a href="index.php?m=package&file=friend&id={$id}">{$lang.send_to_friend}</a> </td>
	<td><img src=images/book.gif border=0 align=absmiddle> <a href="index.php?m=package&file=package_request&id={$id}">{$lang.request_enquiry}</a> </td>
	</tr>
	{if $phone<>""}
	<tr>
	<td colspan="3" align="right"><h1> {$phone}</h1></td>
	{/if}
	</tr>
</table>

</td></tr>
<tr><td>
	<!--printstart-->

<table width="100%"><tr><td valign="top"><br>
<h3>{$package.package_name} ${$package.package_cost}</h3><br>
	{$content}
	{if $package.package_file_name}
	<hr>
	<img src="modules/package/images/browse.gif" align="absmiddle"> <a href="index.php?m=package&file=packagedetails&op=viewPackageFile&id={$package.package_id}">More details of the package</a>.{/if}
	</td><td valign="top" align="right">{if $package.package_photo}<img src="images/packages/{$package.package_photo}">{/if}</td></tr></table>
</td></tr>
</table>
	<!--printend-->

 <br>

{if $found>1}
<table class="yellowbg" width="100%">
<tr><td>{$lang.displaying}: {$start}-{$end} {$lang.of} {$found} {$lang.page} » {$lang.page} {$currentpage}</td><td> {$pagelink}</td></tr>
</table>
{/if}

{if $smarty.session.admin}<a href="admin.php?op=editpackage&id={$package.package_id}">Edit</a>{/if}
