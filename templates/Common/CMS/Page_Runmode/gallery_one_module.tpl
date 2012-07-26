{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript" src="{#js_url#}fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="{#js_url#}fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" href="{#js_url#}fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<script type="text/javascript">{literal}
    $(document).ready(function() {
        $("a.image").fancybox({
            'titlePosition' 	: 'inside'
        });
        
    });
</script>{/literal}
<h1>Фотогалерея {$galleryInfo.name}</h1>
<div id="gallery">
   {foreach from=$page item=i}
   <a class="image {cycle values=',,,nomargin'}" rel="image" href="{#script_url#}gallery/{$i.pic1}" title="{$i.description}">
       <img src="{#script_url#}gallery/thumb_{$i.pic1}" />
   </a>
   {foreachelse}
    Нет фотографий
   {/foreach}
</div>
<div class="clear"></div>
<a href="{#script_url#}{seo_url rm='photogallery'}">Назад</a>
<div id="pagination">
    {if count($num.prepared) > 1}
        <b>Страницы:</b>
        {foreach from=$num.prepared item=item}
            {if $num.current == $item}
                <b>{$item}</b>
            {else}
                <a href="{#script_url#}{seo_url rm='photogallery' param1=$item}" >{$item}</a>
            {/if}
        {/foreach}
    {/if}
</div>
