{config_load file=templates.ini section="common" scope="global"}
{if $article}
    {if $error_article == 1}
	Такой статьи нет
    {else}
    <div id="news">
        <h1><span class="date">{$article.adddate|date_format:"%d.%m.%Y"}</span> {$article.name|escape}</h1>
        {if $article.image}
            <img class="news_logo" src="{#upload#}200_{$article.image}" alt="Картинка для {$article.name|escape}"/>
        {/if}
        <div>{$article.full}</div>
        <div>
            <a href="{#script_url#}{seo_url rm=news}">Назад к списку новостей</a>
        </div>
        <div class="clear"></div>
        <div id="vk_comments"></div>
        <script type="text/javascript">
            {literal}VK.Widgets.Comments("vk_comments", {limit: 10, width: "600", attach: "*"});{/literal}
        </script>
    </div>

    {/if}
{elseif $page_error == 1}
    Ошибка модуля
{else}

    <div id="news">
        {foreach from = $all_news item = item}
        <div class="item">
            
            <h1><span class="date">{$item.adddate|date_format:"%d.%m.%Y"}</span> {$item.name|escape}</h1>
            {if $item.image}
                <img class="news_logo" src="{#upload#}200_{$item.image}" alt="Картинка для {$item.name|escape}"/>
            {/if}
            <div class="social">
                <script type="text/javascript">
                    {literal}
                    <!--
                    document.write(VK.Share.button({
                      url: '{/literal}{#domain_name#}{#script_url#}{seo_url rm=$seo_url param1 = $num_pages.current param2 = "full_article" param3=$item.id}',
                      title: '{$item.name|escape}',
                      description: '{$item.name|escape}',
                      //image:'{#domain_name#}{#upload#}200_{$item.image}{literal}',
                      noparse: false
                    }, {
                      type: 'custom',
                      text: '<img style="vertical-align: middle;border:0;" src="https://vk.com/images/vk16.png" title="Опубликовать Вконтакте">'
                    }));
                    -->
                    {/literal}
                </script>
            </div>
            <div class="text">
                <div class="short_text">
                    {$item.short}
                </div>
                {if $item.full}
                <div class="detail">
                    <a href="{#script_url#}{seo_url rm=news param1 = 'detail' param2=$item.id}">Подробнее...</a>
                </div>
                {/if}
                
            </div>
            <div class="clear"></div>
        </div>
        {/foreach}

        <div class="Pagination">
            {if $num_pages.pages > 1}
                <b>Страницы</b>
                {foreach from=$num_pages.prepared item=item key=key}
                <a href="{#script_url#}{seo_url rm=$seo_url param1=$item}">
                    {if $num_pages.current==$item}<b>{/if}
                    {$item}
                    {if $num_pages.current==$item}</b>{/if}
                </a>
                {/foreach}
            {/if}
        </div>
    </div>

{/if}
{if $error_article == 1}
    Статья не существует
{/if}