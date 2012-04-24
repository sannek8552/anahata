{config_load file=templates.ini section="common" scope="global"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $seo_data.page_title}Модный ребенок :: {$seo_data.page_title}{else}Модный ребенок{/if}</title>
{if $seo_data.page_description}<meta name="description" content="{$seo_data.page_description}" />{/if}
{if $seo_data.keywords}<meta name="keywords" content="{$seo_data.keywords}" />{/if}

<link href="{#img_url#}favico.ico" rel="shortcut icon" type="image/x-icon" />
<link href="{#css_url#}main.css?1=2" rel="stylesheet" type="text/css" />
<link href="{#css_url#}style.css" rel="stylesheet" type="text/css" />
<link  href="{#css_url#}slimbox.css" rel="stylesheet" type="text/css" media="screen" />
<link  href="{#css_url#}jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
        var script_url = '{#script_url#}';
        var images_prefix = '{#img_url#}';
        var ajax_prefix = '{#script_url#}';
        var common_prefix = '{#common_url#}';        
</script>
<script type="text/javascript" src="{#js_url#}validator_o.js"></script>

<script type="text/javascript" src="{#js_url#}AJAX.js"></script>
<script type="text/javascript" src="{#js_url#}body_blocker.js"></script>
<script type="text/javascript" src="{#js_url#}jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="{#js_url#}jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="{#js_url#}jquery.placeholder.min.js"></script>
<script type="text/javascript">        
    {literal}        
        $(document).ready(function(){
            jQuery('input[placeholder], textarea[placeholder]').placeholder();
            init_additional();
            {/literal}{$text_to_init}{literal}

            $('#search_form').bind('submit', function(){
                var url = '{/literal}{#script_url#}{literal}Search/';
                url += $("#search_form input[name='search']").val() + '.html';
                $('#search_form').attr('action', url);
            });

            
        });
{/literal}        
    </script>
{literal}
<script type="text/javascript">
    function init_additional()
    {

    }
    //jQuery('input[placeholder], textarea[placeholder]').placeholder();
    </script>
{/literal}



</head>
<body>
<div id="wrapper">
    <div id="container">
        <div id="header">
            <a href="{#script_url#}index.html" style="position: absolute; top: 10px; left: 320px; width: 190px; height: 110px;" title="Модный ребенок :: Главная"></a>
            <div id="contacts">
                <div class="head">Контакты:</div>
                г. Томск<br/>
                Адрес: Учебная 37а<br/>
                Тел. 41-99-69<br/>
                Сот. 8-923-402-23-74<br/>
                <a href="mailto:modrebenok@sibmail.com">modrebenok@sibmail.com</a>
            </div>

        </div>
        <div id="menu">
            <ul>
                <li {if $seo_data.page_title == 'Модный ребенок'}class="active"{/if}><a href="{#script_url#}{seo_url rm='index'}"  ><div style="width:77px">Главная</div><div class="rside"></div></a></li>
                <li {if $seo_data.page_title == 'О нас'}class="active"{/if}><a href="{#script_url#}{seo_url rm='About'}"  ><div style="width:68px">О нас</div><div class="rside"></div></a></li>
                <li {if $seo_data.page_title == 'Статьи'}class="active"{/if}><a href="{#script_url#}{seo_url rm='Article'}"  ><div style="width:68px">Статьи</div><div class="rside"></div></a></li>
                <li {if $seo_data.page_title == 'Second Hand'}class="active"{/if}><a href="{#script_url#}{seo_url rm='Second-Hand'}"  ><div style="width:130px">Second Hand</div><div class="rside"></div></a></li>
                <li {if $seo_data.page_title == 'Сток'}class="active"{/if}><a href="{#script_url#}{seo_url rm='Stock'}" ><div style="width:55px">Сток</div><div class="rside"></div></a></li>
                <li {if $seo_data.page_title == 'Контакты'}class="active"{/if}><a href="{#script_url#}{seo_url rm='Contacts'}" ><div style="width:87px">Контакты</div><div class="rside"></div></a></li>
                <li {if $seo_data.page_title == 'Приём на комиссию'}class="active"{/if}><a href="{#script_url#}{seo_url rm='Payment'}" ><div style="width:170px">Приём на комиссию</div><div class="rside"></div></a></li>
                <li  {if $seo_data.page_title == 'Гостевая книга'}class="active"{/if}><a href="{#script_url#}{seo_url rm='Guestbook'}" ><div style="width:135px">Гостевая книга</div><div class="rside"></div></a></li>
            </ul>

        </div>
        <div id="ad">

            <a href="#"><img src="{#img_url#}ff_baner.jpg" alt="baner"/></a>
            <a href="#"><img src="{#img_url#}baner2.jpg" alt="baner"/></a>
            <a href="#"><img src="{#img_url#}sg_baner.jpg" alt="baner" class="nomargin"/></a>
        </div>
        <div class="clear"></div>
        <div id="main" >
            <div id="leftColumn">
                <div id="leftMenu">
                    <ul class="firstLevel">
                        {foreach from=$categories item=item}
                        <li class="expanded">
                            <a href="{#script_url#}{seo_url rm='Category' param1=$item.id}">{$item.title}</a>
                            {if $item.sub}
                                {include file="sub_cat.tpl" items=$item.sub level=2}
                            {/if}
                        </li>

                        {/foreach}
                        <li class="expanded leftHead">
                            <select name="brand_id"  onchange="window.location = this.value" style="margin-top: 5px;">
                                <option value="">Производители</option>
                            {foreach from=$brands item=item key=key}
                                <option value="{#script_url#}{seo_url rm=Brands param1=$item.seo_url}" {if $key == $brand_id}selected{/if}>{$item.title}</option>
                            {/foreach}
                            </select>
                        </li>
                    </ul>
                </div>
            </div>

          <div id="content">

                {if $body}
                    {include file=$body}

                {elseif $body_as_text}
                    {$body_as_text}

                {/if}
          </div>
        <div id="rightColumn">

            <div class="block" id="search">
                <div class="header">
                    <form action="" method="post" id="search_form">
                        <input type="text" name="search" placeholder="Поиск..." class="search" value="{$search}"/>
                    </form>
                </div>
                <div class="content"></div>
            </div>

            <div class="block" id="campaign">
                <div class="header">
                    <a href="{#script_url#}{seo_url rm='Campaign'}">Акции</a>
                </div>
                <div class="content">
                    [news_module?section=8&short_list=1]
                </div>
            </div>
            <!--<div class="block" id="discount">
                <div class="header">
                    <a href="{#script_url#}{seo_url rm='Discount'}">Скидки</a>
                </div>
                <div class="content">
                    {if $discount}
                         <div class="image">
                            <a href="{#script_url#}{seo_url rm='Product' param1=$discount[0].id}">
                                <img src="{#picture_url#}block_{$discount[0].picture1}" alt="{$discount[0].name}" />
                            </a>
                        </div>
                        <div class="name">
                            <a href="{#script_url#}{seo_url rm='Product' param1=$discount[0].id}">{$discount[0].name}</a>
                        </div>
                        <div class="oldprice">{$discount[0].price|money} р.</div>
                        <div class="newprice">{$discount[0].newprice|money} р.</div>
                    {else}
                        Нет скидок
                    {/if}
                </div>
            </div>-->
            <div class="block" id="featured">
                <div class="header">
                    <a href="{#script_url#}{seo_url rm='Featured'}">Новинки</a>
                </div>
                <div class="content">
                    {if $featured}
                        <div class="image">
                            <a href="{#script_url#}{seo_url rm='Product' param1=$featured[0].id}">
                                <img src="{#picture_url#}block_{$featured[0].picture1}" alt="{$featured[0].name}" />
                            </a>
                        </div>
                        <div class="name">
                            <a href="{#script_url#}{seo_url rm='Product' param1=$featured[0].id}">{$featured[0].name}</a>
                        </div>
                        <div class="price">{$featured[0].price|money} р.</div>
                    {else}
                        Нет новинок
                    {/if}
                </div>
            </div>
            <!--
            <div class="block" id="discount">
                <div class="header">
                    <a href="#">Акции</a>
                </div>
                <div class="content">
                    Нет акций
                </div>
            </div>
            -->
            <div class="block" id="news">
                <div class="header">
                    <a href="{#script_url#}{seo_url rm='News'}">Новости</a>
                </div>
                <div class="content">
                    [news_module?section=6&short_list=1]
                </div>
            </div>
            <div class="block" id="discount">
                <div class="header">
                    <a href="{#script_url#}{seo_url rm='Photogallery'}">Фотогалерея</a>
                </div>
                <div class="content">
                    {if $gallery_photo}
                    <a href="{#script_url#}{seo_url rm='Photogallery'}">
                        <img src="{#script_url#}gallery/thumb_{$gallery_photo}" alt="Галерея"/>
                    </a>
                    {else}
                        Нет галереи
                    {/if}
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div id="footer">
            <p>Магазин недорогой и качественной детской одежды из Европы «МОДНЫЙ РЕБЕНОК» г. Томск</p>
        </div>
        </div>
    </div>
</div>
</body>
</html>