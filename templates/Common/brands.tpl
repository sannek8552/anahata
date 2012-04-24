{config_load file=templates.ini section="common" scope="global"}

{if $brand_id}
<div id="brandsTop">
	<h1>{$brand.title}</h1>
	{$brand.description}
</div>
<div id="brandProducts">
	<h3>Товары производителя "{$brand.title}"</h3>
        <div><b>Найдено {$product_count} товар(ов)</b></div>
        <div class="clear" ></div>
        {foreach from=$products item=row}
            {foreach from=$row item=product}
                    <div class="product_div">
                        <div class="image">
                            <a href="{#script_url#}{seo_url rm='Product' param1=$product.id}">
                                <img src="{#picture_url#}block_{$product.picture1}" alt="{$product.name}" />
                            </a>
                        </div>
                        <div class="name">
                            <a href="{#script_url#}{seo_url rm='Product' param1=$product.id}">{$product.name}</a>
                        </div>
                        <div class="price">{$product.price} р.</div>
                    </div>
            {/foreach}
        {/foreach}

</div>
<div style="clear:both" ></div>
<div class="Pagination">
        {if count($page_array) > 1}
	<b>Страницы: </b>
            {foreach from=$page_array item=item}
                {if $page == $item}
                    <b>{$item}</b>
                {else}
                    <a href="{#script_url#}{seo_url rm='Brands' param1=$brand.seo_url param2=$item}" >{$item}</a>
                {/if}
            {/foreach}
        {/if}
  </div>
{else}
    <h1>Производители</h1>
    {foreach from=$brands item=item}
            <div>
                <a href="{#script_url#}{seo_url rm='Brands' param1=$item.seo_url}">{$item.title}</a>
            </div>
    {/foreach}

{/if}
