{config_load file=templates.ini section="common" scope="global"}
<div id="featured">
{foreach from=$products item=product key=key}
<div class="featuredOne">
	
	<div class="b"><a href="{#script_url#}{seo_url rm="Product" param1=$product.seo}" ><img src="{#script_url#}{show_image id=$product.id width=width height=height}" alt="{$product.name}" /><div><p>{$product.name}</p></div></a></div>
</div>
{/foreach}
</div>