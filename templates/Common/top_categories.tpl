{config_load file=templates.ini section="common"}
{assign var=bcolor value=rowOdd}
{foreach from=$top_categories item=item}
{if $count == 0}
	{assign var=count value=1}
{else}
	{assign var=count value=$count+1}
{/if}
<div class="product_div {$bcolor}" >  
  <a href="{#script_url#}{seo_url rm="Category" param1=$item.seo_url}" >
    {if $item.picture_product_id}
    	{if $item.seo_url == 'Certificates'}
    		<img src="{#script_url#}{show_image id=$item.picture_product_id width=width height=height param1=2}" alt="{$item.title}" />
    	{else}
    		<img src="{#script_url#}{show_image id=$item.picture_product_id width=width height=height}" alt="{$item.title}" />
  		{/if}
    {else}
    <div></div>
	  {/if}
   	  <div>
   	      <p>{$item.title}</p>
   	  </div>
    </a></div>
{if $count == 4}
	{cycle values="rowEven,rowOdd" assign=bcolor}
	{assign var=count value=0}
{/if}

{/foreach}