{config_load file=templates.ini section="common" scope="global"}
<div class="short_news" >
{foreach from = $all_news item = item}
<div class="item">
    <div class="news_date">{$item.adddate|date_format:"%d-%m-%Y"} {$item.addtime|date_format:"%H:%M"}</div>
    <div class="news_name">
        <h2>{$item.name|escape}</h2>
    </div>
    <div class="news_description">
        {if $item.short}
            {$item.short}
            {if $item.full}
                <a href="{#script_url#}{seo_url rm=$seo_url param1 = 1 param2 = 'full_article' param3=$item.id}">Подробнее...</a>
            {/if}
        {/if}
    </div>
    
</div>
{foreachelse}
    Нет записей
{/foreach}
</div>

