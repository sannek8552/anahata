{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript" src="{#js_url#}product.js" ></script>
<div id="bodyContent">
    <h1>Фотогалерея</h1>
    <div id="photogallery">
        {foreach from=$galleries item=item}
            <div class="item">
                <a href="{#script_url#}{seo_url rm='Photogallery' param1=$item.id}" alt="">{$item.name}</a>
            </div>
        {/foreach}
        <div class="clear"></div>
    </div>
</div>