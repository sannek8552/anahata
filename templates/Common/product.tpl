{config_load file=templates.ini section="common"}
<script type="text/javascript" src="{#js_url#}jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="{#js_url#}fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="{#js_url#}fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" href="{#js_url#}fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
    {literal}
    $(document).ready(function() {
        $("a.gallery").fancybox();
        $('#thumbs a').click(function(){
            $('.gallery img').attr('src',  $(this).attr('href'));
            $('.gallery').attr('href',  $(this).attr('rel'));
            $('#thumbs a').each(function(){
                $(this).removeClass('current');
            });
            $(this).addClass('current');
            return false;
        });
    });
{/literal}
</script>
<div id="product">
{if $pdata.inactive == 1 || $inactive_product}
      <h1>Продукт не активный</h1>
{else}
<script type="text/javascript" src="{#js_url#}product.js" ></script>
    <h1 class="cart">{$pdata.name}</h1>
    <div class="pictureBox">
        <a class="gallery" href="{#picture_url#}{$pdata.picture1}">
            <img src="{#picture_url#}main_{$pdata.picture1}"/>
        </a>
        <div id="thumbs">
            {if $pdata.picture1}
            <a href="{#picture_url#}main_{$pdata.picture1}" rel="{#picture_url#}{$pdata.picture1}"><img src="{#picture_url#}thumb_{$pdata.picture1}"/></a>{/if}
            {if $pdata.picture2}
            <a href="{#picture_url#}main_{$pdata.picture2}" rel="{#picture_url#}{$pdata.picture2}"><img src="{#picture_url#}thumb_{$pdata.picture2}"/></a>{/if}
            {if $pdata.picture3}
            <a href="{#picture_url#}main_{$pdata.picture3}" rel="{#picture_url#}{$pdata.picture3}"><img src="{#picture_url#}thumb_{$pdata.picture3}"/></a>{/if}
            {if $pdata.picture4}
            <a href="{#picture_url#}main_{$pdata.picture4}" rel="{#picture_url#}{$pdata.picture4}"><img src="{#picture_url#}thumb_{$pdata.picture4}"/></a>{/if}
        </div>
    </div>
    <div class="description">
        <div class="productName"></div>
        <div class="productDescription"><b>Описание: </b><br />{$pdata.description}</div>
        {if $pdata.newprice > 0}
            <div class="oldProductPrice">Старая цена: <span>{$pdata.price|money}</span> руб.</div>
            <div class="newProductPrice">Новая цена: <span>{$pdata.newprice|money}</span> руб.</div>
        {else}
            <div class="productPrice">Цена: <span>{$pdata.price|money}</span> руб.</div>
        {/if}
    </div>

{/if}
</div>
