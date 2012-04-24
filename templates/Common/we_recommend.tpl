{config_load file=templates.ini section="common"}


{if $cross_sells}
	<div id="crossSell">			
	  {foreach from=$cross_sells item=item key=key}
		{assign var=cur_seo value=$products[$item.cross_product_id].seo}
		<div>
			<div id="productImg">
				<a href="{#script_url#}{seo_url rm="Product" param1="$cur_seo"}" ><img src="{#script_url#}{show_image id=$products[$item.cross_product_id].id width=cross_width height=cross_height}" title="<div style='background-color:#ffffff;padding:5px;'><IMG src='{#script_url#}{show_image id=$products[$item.cross_product_id].id width=cross_tip_width height=cross_tip_height}'/></div>" class="Tips2"/></a>
<div>
				{$products[$item.cross_product_id].name}<br />
				{$products[$item.cross_product_id].description}
			</div>   
			</div>
		</div>
		{/foreach}
	</div>
			<div style="clear:both;" ></div>
{/if}