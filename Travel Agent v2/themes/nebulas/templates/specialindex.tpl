<table class="yellowbg" width="100%">
<tr><td><a href="index.php">{$lang.home}</a> >> {$lang.special}> </td><td align="right">{$lang.found} {$found} {$lang.displaying}: {$start}-{$end} of {$found} {$lang.specials} » {$lang.page} {$currentpage}</td><td> {$pagelink}</td></tr>
</table>
<table width=100% class="lightyellow"    cellpadding="2" cellspacing="0"  >
<tr><td>
<table  width=100% cellpadding="2" cellspacing="0" nowrap  class="whitebg">
<tr class="package"><td>Fare</td><td>{$lang.price}</td><td>{$lang.purchase_by}</td><td>{$lang.more}</td></tr>
{section name="idx" loop="$special"}
<tr bgcolor="{cycle values="#eeeeee,#dddddd"}"><td>{if $special[idx].fare_title}{$special[idx].fare_title}{else}{$special[idx].origin_name} » {$special[idx].destination_name}{/if}</td><td>${$special[idx].fare_adultfare}</td><td>{$special[idx].fare_purchaseby|date_format}</td><td><a href="index.php?m=fare&id={$special[idx].fare_id}">Click  here..</a></td></tr>
{/section}
</table>
</td></tr></table>
