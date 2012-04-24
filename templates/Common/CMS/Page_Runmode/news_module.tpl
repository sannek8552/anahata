{config_load file=templates.ini section="common" scope="global"}
{if $article}
    {if $error_article == 1}
	Такой статьи нет
    {else}
	
	<h2>{$article.name|escape}</h2>
        <div>{$article.full}</div>
        <div><em>Добавлена {$article.adddate|date_format:"%d-%m-%Y"} {$article.addtime|date_format:"%H:%M"}</em></div>
        <div><a href="{#script_url#}{seo_url rm=$seo_url param1 = $hid_current}">Назад</a><br />
          <br />
        </div>
    {/if}
{elseif $page_error == 1}
    Ошибка модуля
{else}
    <div><h1>{$news_name}</h1></div>
	{foreach from = $all_news item = item}
	<div >
	  <h2>{$item.name|escape}</h2>
	</div>
	<div> {if $item.short}{$item.short}{if $item.full}<a href="{#script_url#}{seo_url rm=$seo_url param1 = $num_pages.current param2 = 'full_article' param3=$item.id}">Подробнее...</a>{/if}{/if}</div>
	<div><br />
      <em>Добавлена {$item.adddate|date_format:"%d-%m-%Y"} {$item.addtime|date_format:"%H:%M"}</em></div>
	<br/>
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

{/if}
{if $error_article == 1}
	Статья не существует
	{/if}