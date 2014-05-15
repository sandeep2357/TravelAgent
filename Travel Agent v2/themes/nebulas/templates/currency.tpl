<table align="center" width="100%">
<tr><td class="title">Currency Coverter. <hr>Enter an amount in any currency below<br>
</td></tr>

</table>

<form name="currency">
{literal}
<script language="JavaScript">
<!--

// Permission granted to SimplytheBest.net to feature the script in the DHTML script collection
// Courtesy of SimplytheBest.net - http://simplythebest.net/scripts/
	var rate = new Array({/literal}1,{$option}{literal});
	function currency_convert(origin) {
		var origin_value = eval('document.currency.c'+origin+'.value');
		var euro_equivalent = rate[origin];
		var v;
		for (i=0; i<rate.length; i++) {
			if (i!=origin) {
				v = Math.round(rate[i]*origin_value/euro_equivalent*100)/100;
				eval('document.currency.c'+i+'.value = '+v);
			}
		}
		return true;
	}
// -->
</script>
{/literal}
{assign var=i value=0}
{assign var=j value=1}

<table cellspacing="1" cellpadding="1" border="0" align="center">
<tr>
<td><img src="images/flags/us.gif" alt="USA" width="30" height="20"></td>
<td>US$</td>
<td><input type="text" name="c0" value="" size="10" onKeyUp="currency_convert(0);"></td>
</tr><tr>
{foreach from=$currency item=currency key=cid}

<td><img src="images/flags/{$currency.currency|lower}.gif" alt="{$currency.country}" width="30" height="20"></td>
<td>{$currency.currency}</td>
<td><input type="text" name="c{$j}" value="" size="10" onKeyUp="currency_convert({$j});"></td>
{if $i==3}
{assign var="i" value="0"} 

</tr><tr>
{/if}
{assign var=i value=$i+1}
{assign var=j value=$j+1}

{/foreach}
</tr>


<tr><td colspan=7><input type="Reset" value="Clear All Values">
</table>
</form>