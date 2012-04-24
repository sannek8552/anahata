{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript">
    {literal}
    $(document).ready(function(){
        $('#search_frm').bind('submit', function(){
            var url = '{/literal}{#script_url#}{literal}Search/';
            url += $("#search_frm input[name='search']").val() + '.html';
            $(this).attr('action', url);
            //return false;
        });
        $('input[type=submit]').button();
    });
    {/literal}
</script>
<div id="bodyContent"> 
    <div>
        <form action="" method="post" id="search_frm">
            <input type="text" value="{$search}" name="search"/> <input type="submit" value="Поиск"/>
        </form>
    </div>

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
                    <div class="category">{$product.category_name}</div>
                    <div class="price">{$product.price} р.</div>
                </div>
        {/foreach}
    {/foreach}
    <div class="clear"></div>
    <div class="Pagination">
        {if count($info.prepared) > 1}
            <b>Страницы:</b>
            {foreach from=$info.prepared item=item}
                {if $page == $item}
                    <b>{$item}</b>
                {else}
                    <a href="{#script_url#}{seo_url rm='Search' param1=$search param2=$item}" >{$item}</a>
                {/if}
            {/foreach}
        {/if}

    </div>

</div>