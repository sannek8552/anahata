{config_load file=templates.ini section="common" scope="global"}
<div>
	<ul type="disc">
		 {foreach from=$map item=s_item key=s_key}
	          <li>
	          <a href="{if $s_item.direct_link}{$s_item.seo_url}{else}{#script_url#}{seo_url rm=$s_item.seo_url}{/if}" class="fly">
	            {$s_item.title}
	            {if $s_item.sub}
	            {include file="Common/CMS/Page_Runmode/sitemap_sub.tpl" items=$s_item.sub}
	            {else}
	            </a>
	            {/if}
	          </li>
	     {/foreach}
      		<li>
	          	<a href="{#script_url#}{seo_url rm="Products"}" class="fly" >Products</a>
	          		<ul type="circle">
	          			{foreach from=$products item=product key=pkey}	          		        					          			
	        				<li>
	            				<a href="{#script_url#}{seo_url rm=Product param1=$product.seo}" class="fly">{$product.name}</a>
	        				</li>	        				
        				{/foreach}
    				</ul>	          	
	          </li>
	          {if $map_categories}
	          <li>
	          	Categories
	          		<ul type="circle">
	          			{foreach from=$map_categories item=category key=pkey}	          		        					          			
	        				<li>
	            				<a href="{#script_url#}{seo_url rm=Category param1=$category.seo_url}" class="fly">
	            					{$category.title}
	            				{if $category.sub}
	            					{include file="Common/CMS/Page_Runmode/sitemap_category_sub.tpl" items=$category.sub}
	            				{else}
	            				</a>
	            				{/if}
	        				</li>	        				
        				{/foreach}
    				</ul>	          	
	          </li>
	          {/if}
     </ul>
</div>