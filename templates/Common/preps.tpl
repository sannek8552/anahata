{config_load file=templates.ini section="common" scope="global"}
<div id="preps">
    <h1>Преподаватели</h1>
    {foreach from = $preps item = item}
    <div class="item">
        {if $item.photo}
            <img class="news_logo" src="{#upload#}thumb_{$item.photo}" alt="Фотография {$item.fio|escape}"/>
        {/if}
        <div class="social">
            <script type="text/javascript">
                {literal}

                document.write(VK.Share.button({
                  url: '{/literal}{#domain_name#}{#script_url#}{seo_url rm=$seo_data.seo_url}',
                  title: '{$item.fio|escape}',
                  description: 'Преподаватель школы йоги Анахата',
                  image: '{#domain_name#}{#upload#}thumb_{$item.photo}{literal}',
                  noparse: true
                }, {
                  type: 'custom',
                  text: '<img style="vertical-align: middle;border:0;" src="https://vk.com/images/vk16.png" title="Опубликовать Вконтакте">'
                }));
                
                {/literal}
            </script>
        </div>
        <div class="text">
            <h2>{$item.fio|escape}</h2>
            <div class="bio">
                {$item.bio}
            </div>
        </div>
        <div class="clear"></div>
    </div>
    {foreachelse}
        Нет преподавателей
    {/foreach}
</div>

