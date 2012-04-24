{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript" src="{#js_url#}product.js" ></script>

<div id="bodyContent">
<h1>My Wishlist</h1>
{if $message}
<div>{$message}</div>
{/if}
<div class="page_container">
	{foreach from=$pids item=item}	
	{assign var=pid value=$item.product_id}
	{assign var=product value=$products[$pid]}
	<div style="clear:both;">
		{include file='Common/single_product.tpl' product=$product wishlist=1}
	</div>
	{foreachelse}
	<p>Your wishlist is empty</p>
	{/foreach}
</div>
</div>