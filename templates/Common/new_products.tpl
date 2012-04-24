{config_load file=templates.ini section="common"}
<div id="bodyContent">
<h1>New Products</h1>

	{foreach from=$products item=row}
    	{cycle values="rowOdd,rowEven" assign=bcolor}
        {foreach from=$row item=product}        	
                <div class="product_div {$bcolor}" >  
	               	<a href="{#script_url#}{seo_url rm="Product" param1=$product.seo}" >					
	                   	<img src="{#script_url#}{show_image id=$product.id width=width height=height}" alt="{$product.name}" />						                  	
	                   	<div>
	                    	<p>{$product.name}</p>
	   	           	    </div>
	   	       	  	</a>
                </div>								
            {/foreach}
	{foreachelse}
	No products found
	{/foreach}
	<div>
    		<div style="clear:both" /></div><br />
<br />

	Page(s) {foreach from=$pages item=item}
		{if $page == $item}
			<b>{$item}</b>
		{else}
			<a href="{#script_url#}{seo_url rm="NewProducts" param1=$item}" >{$item}</a>
		{/if}
	{/foreach}
	</div>
</div>
<script type="text/javascript" src="{#js_url#}product.js"></script>