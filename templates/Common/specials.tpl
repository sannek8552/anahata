{config_load file=templates.ini section="common" scope="global"}
<div id="bodyContent">
	{foreach from=$specials item=product}
		{cycle values="rowOdd,rowEven" assign=bcolor}
		{include file='Common/single_product.tpl' product=$product bcolor=$bcolor}
	{foreachelse}
	no specials found
	{/foreach}

	<div style="margin-top:10px;">
	{if $page_array}
		Pages: {foreach from=$page_array item=item key=key}
					{if $item == $page}<b>{$item}</b>
					{else} <a href="{#script_url#}{seo_url rm="Specials" param1=$item}">{$item}</a>
					{/if}
				{/foreach}
	{/if}
	</div>
</div>