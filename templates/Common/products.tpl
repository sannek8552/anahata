{config_load file=templates.ini section="common" scope="global"}

<script type="text/javascript" src="{#js_url#}product.js" ></script>
	<div class="page_container">
<h1>All Products</h1>
		{foreach from=$products item=product}
			{cycle values="rowOdd,rowEven" assign=bcolor}
			{include file='Common/single_product.tpl' product=$product bcolor=$bcolor}
                {foreachelse}
                    {if $search}No products matching the query{/if}
		{/foreach}
		<div style="clear:both" /></div>
			<div style="margin-top:10px;">
                                {if !empty($page_array)}
				Pages:{foreach from=$page_array item=item key=key}
							{if $item == $page}<b>{$item}</b>
							{elseif  $search}
                                                            <a href="{#script_url#}{seo_url rm=Products param1=search param2=$search_value param3=$item}">{$item}</a>
                                                        {else}
                                                            <a href="{#script_url#}{seo_url rm=Products param1=$item}">{$item}</a>
							{/if}
					{/foreach}
                                {/if}
</div></div>