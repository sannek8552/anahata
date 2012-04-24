{config_load file=templates.ini section="common"}
<div id="bodyContent">
    <script type="text/javascript" src="{#js_url#}product.js"></script>
    {if $category_inactive}
        Категория не активна.
    {elseif  !$current_subcat}
    <div class="subcategory_list">
        <h1> Список подкатегорий для категории "{$current_category.title}"</h1>
        {foreach from=$childs item=item}
            <div class="item">
                <a href="{#script_url#}{seo_url rm='Category' param1=$item.id}">{$item.title}</a>
            </div>
        {/foreach}
    </div>
    {else}
        <h1>{$current_subcat.title}</h1>
        <div><b>Найдено {$products_count} товар(ов)</b></div>
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
                <b>Страницы:</b>
                {foreach from=$pages item=item}
                    {if $page == $item}
                        <b>{$item}</b>
                    {else}
                        <a href="{#script_url#}{seo_url rm='Category' param1=$cur_cat param2=$item}" >{$item}</a>
                    {/if}
                {/foreach}
            {/if}

        </div>
    {/if}
</div>
