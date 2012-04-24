{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript" src="{#js_url#}product.js" ></script>
<div id="bodyContent">
<h1>Новинки</h1>
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
                    {if $product.newprice}
                        <div class="old price">{$product.price|money} р.</div>
                        <div class="new price">{$product.newprice|money} р.</div>
                    {else}
                        <div class="price">{$product.price|money} р.</div>
                    {/if}
                </div>
        {/foreach}
    {/foreach}
    <div class="clear"></div>
    <div class="Pagination">
        {if count($pages) > 1}
        <b>Страницы</b>
        {foreach from=$pages item=item}
            {if $page == $item}
                <b>{$item}</b>
            {else}
                <a href="{#script_url#}{seo_url rm='Featured' param1=$item}" >{$item}</a>
            {/if}
        {/foreach}
        {/if}
    </div>
</div>