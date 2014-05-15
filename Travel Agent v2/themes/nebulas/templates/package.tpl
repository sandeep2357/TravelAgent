<table class="yellowbg" width="100%">
<tr><td><a href="index.php">{$lang.home}></a> >>{$lang.packages}></td><td align="right">{$lang.found} {$found} {$lang.packages}.{$lang.displaying}: {$start}-{$end} {$lang.of} {$found} {$lang.packages} » Pages : {$lang.package}{$currentpage}</td><td> {$pagelink}</td></tr>
</table>
<table width=100% class="lightyellow"    cellpadding="2" cellspacing="0"  >
<tr><td>
<table  width=100% cellpadding="2" cellspacing="0" nowrap  class="whitebg">
<tr class="package"><td>{$lang.packages}</td><td>{$lang.price}</td><td>{$lang.more}</tr>
{section name="idx" loop="$package"}
<tr bgcolor="{cycle values="#eeeeee,#dddddd"}"><td >{$package[idx].package_name}</td><td>${$package[idx].package_cost}</td><td><a href=index.php?m=package&file=packagedetails&id={$package[idx].package_id}>{$lang.more}..</a></tr>
{/section}
</table>
</td></tr></table>
