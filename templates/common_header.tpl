{config_load file=templates.ini section="common" scope="global"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="nop">
<head>
<link rel="image_src" href="{#domain_name#}{#img_url#}logo.png" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $seo_data.page_title}Анахата :: {$seo_data.page_title}{else}Школа ЙОГИ Анахата{/if}</title>
{if $seo_data.page_description}<meta name="description" content="{$seo_data.page_description}" />{/if}
{if $seo_data.keywords}<meta name="keywords" content="{$seo_data.keywords}" />{/if}

<link href="{#img_url#}favico.ico" rel="shortcut icon" type="image/x-icon" />

<link href="{#css_url#}main.css?1=2" rel="stylesheet" type="text/css" />
<link href="{#css_url#}menu.css?1=2" rel="stylesheet" type="text/css" />
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

<script type="text/javascript" src="{#js_url#}menu.js"></script>
{literal}

<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?49"></script>
<script type="text/javascript" src="http://vk.com/js/api/share.js?11" charset="windows-1251"></script>
<script type="text/javascript">
  VK.init({apiId: 2923829, onlyWidgets: true});
</script>

<script type="text/javascript">        
           
        $(document).ready(function(){
            jQuery('input[placeholder], textarea[placeholder]').placeholder();
            //init_additional();
            {/literal}{$text_to_init}{literal}

            menu.init({
                    mainmenuid: "menu", //menu DIV id
                    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
                    classname: 'menu', //class added to menu's outer DIV
                    //customtheme: ["#1c5a80", "#18374a"],
                    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
            });


            var banner_number = Math.floor(Math.random() * 6) + 1;
            $("#header .banner img").attr('src', '{/literal}{#img_url#}{literal}banner'+banner_number+'.png');
            //alert(banner_number);
            
        });
        
    </script>





{/literal}

</head>
<body>
<div id="wrapper">
    <div id="container">
        <div id="header">
            <a href="{#script_url#}index.html" class="logo" title="Анахата :: Главная"></a>
            <div class="banner">
                <img src="" alt=""/>
            </div>
            <div class="clear"></div>

        </div>
        <div id="menu" class="menu">
            <ul>
                <li {if $seo_data.page_title == $html_home_page.title}class="active"{/if}><a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}">{$html_home_page.title}</a></li>
                {foreach from = $html_menus item = item}
                    <li {if $seo_data.page_title == $item.title}class="active"{/if}><a href="{#script_url#}{seo_url rm=$item.seo_url}">{$item.title}</a>
                    {if $item.sub}
                        {include file="sub_menu.tpl" items=$item.sub level=2}
                    {/if}
                    </li>
                {/foreach}
            </ul>

        </div>

        <div id="main" >
          <div id="content">

                {if $body}
                    {include file=$body}

                {elseif $body_as_text}
                    {$body_as_text}

                {/if}
          </div>
          
        </div>
        <div id="footer">
            <p>Школа ЙОГИ Анахата г. Томск</p>
            <br/>

            <a href="http://region70.ru/" target="_blank" title="Сайты Томска"><img src="http://region70.ru/get88x31/" width="88" height="31" border="0"/></a>
            
            <a href="http://catalog.metka.ru/" title="[METKA.RU] - томский каталог"><img src="http://catalog.metka.ru/counter/counter.php?id=1337703105&im=7&tp=3" border=0 alt="CATALOG.METKA.RU" width=88 height=31/></a>
            
            <span style="margin:0;padding:0" id="tbec"><script type="text/javascript">setTimeout('var tbex=document.createElement("SCRIPT");tbex.type="text/javascript";tbex.src="http://c.tbex.ru/y/4!8831!yoga.tomsk.ru!c.js?rev=2"+String.fromCharCode(38)+"rnd="+(new Date().getTime());(document.getElementsByTagName("head")[0]||document.getElementsByTagName("body")[0]).appendChild(tbex)',1)</script></span><noscript><a href="http://tbe.tom.ru/site/yoga.tomsk.ru/"><img src="http://c.tbex.ru/y/4!8831!yoga.tomsk.ru!c.gif" alt="TBE" /></a></noscript>

            <a href="http://pogodavtomske.ru" title="POGODAVTOMSKE.RU - сайт о погоде в г. Томске"><img src="http://pogodavtomske.ru/informer/inf.php?tp=jpg&f=informer88_31_4.jpg" width="88" height="31" alt="POGODAVTOMSKE.RU - сайт о погоде в г. Томске" title="POGODAVTOMSKE.RU - сайт о погоде в г. Томске"/></a>
        </div>
        
    </div>
</div>
</body>
</html>