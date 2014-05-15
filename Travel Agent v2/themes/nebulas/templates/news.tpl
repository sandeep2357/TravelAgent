<table class="yellowbg" width="100%">
<tr><td><a href="index.php">{$lang.home}</a> >> {$lang.news}</td></tr>
</table>
	
{section name=idx loop=$news}
<table>
<tr><td class=btitle><a href="index.php?m=news&file=readnews&id={$news[idx].news_id}">{$news[idx].news_title}</a></td></tr>
<tr><td align="justify">{$news[idx].news_sdesc|nl2br}</td></tr>
</table><br>
{/section}