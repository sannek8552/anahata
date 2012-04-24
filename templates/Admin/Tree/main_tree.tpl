{config_load file=templates.ini section="common" scope="global"}

<table width="100%">
{foreach from=$cfg item=item key=key}
<tr>
	<td align="center">
	<a href="{#script_url#}{seo_url param1=$key}">{$key}</a>
	</td>
</tr>
{/foreach}
</table>