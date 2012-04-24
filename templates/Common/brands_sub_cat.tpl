{config_load file=templates.ini section="common" scope="global"}

{foreach from=$tree item=titem key=tkey}
<div style="padding-left:15px;">
	<a href="{#script_url#}{seo_url rm="Category" param1=$titem.seo_url}" >{$titem.title}</a>
	{if $titem.sub}
			{include file='Common/brands_sub_cat.tpl' tree=$titem.sub}
			<br />
	{/if}
</div>
{/foreach}