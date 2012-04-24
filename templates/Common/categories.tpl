{config_load file=templates.ini section="common"}
<div id="bodyContent">

{foreach from=$tops item=top}
	{cycle values="rowOdd,rowEven" assign=bcolor}
<div class="fblikeF"><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like simple="1" href="{if $seo_url}{#domain_name#}{#script_url#}{seo_url rm=$seo_url}{else}{#domain_name#}{#script_url#}{seo_url}{/if}" width="180"></fb:like>
</div>
	<h1><a href="{#script_url#}{seo_url rm="Category" param1=$top.seo_url}">{$top.title}</a></h1>
	{*<a href="{#script_url#}{seo_url rm="Category" param1=$top.seo_url}"><img src="{#picture_url#}{$top.picture}" alt="{$top.title}" border="none" /></a>*}
	<div class="top_category_desctiption">
		{$top.description}
	</div>
	<div>
		{foreach from=$childs item=child}
		{if $child.parent_id == $top.id}
			<div class="product_div {$bcolor}" >
                    <div class="b">
                    	<a href="{#script_url#}{seo_url rm="Category" param1=$child.seo_url}" >
							{if $child.picture_product_id}
							<img src="{#script_url#}{show_image id=$child.picture_product_id width=width height=height}" alt="{$child.title}" />
                    		{else}
                    		<div style="margin:15px 10px 5px 20px; border: none;width:170px;height:175px;" ></div>
                    		{/if}
	                    	<div>
	                    		<p>{$child.title}</p>
	                    	</div>
                    	</a>
                    </div>
            </div>            
		{/if}
		{/foreach}
		<div style="clear:both;" ></div>
	</div>
{/foreach}
<div style="margin-top:10px;">
	Pages: {foreach from=$page_array item=item key=key}
				{if $item == $page}<b>{$item}</b>
				{else} <a href="{#script_url#}{seo_url rm="Categories" param1=$item}">{$item}</a>
				{/if}
			{/foreach}
</div>
</div>
<script type="text/javascript" src="{#js_url#}product.js"></script>