{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript" src="{#js_url#}product.js" ></script>
<div id="bodyContent">
<h1>Товары со скидкой</h1>
    {foreach from=$products item=product}
                <div class="product_div">
                    <div class="image">
                        <a href="{#script_url#}{seo_url rm='Product' param1=$product.id}">
                            <img src="{#picture_url#}block_{$product.picture1}" alt="{$product.name}" />
                        </a>
                    </div>
                    <div class="name">
                        <a href="{#script_url#}{seo_url rm='Product' param1=$product.id}">{$product.name}</a>
                    </div>
                    <div class="oldprice">{$product.price|money}</div>
                    <div class="newprice">{$product.newprice|money}</div>
                </div>
    {foreachelse}
        Нет товаров со скидками
    {/foreach}
    <div class="clear"></div>
    <div class="Pagination">
        {if $pages|@count > 1}
            <b>Страницы</b>
            {foreach from=$pages item=item}
                {if $page == $item}
                    <b>{$item}</b>
                {else}
                    <a href="{#script_url#}{seo_url rm='Discount' param1=$item}" >{$item}</a>
                {/if}
            {/foreach}
        {/if}
    </div>
</div>