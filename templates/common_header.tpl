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

            /*$('#search_form').bind('submit', function(){
                var url = '{/literal}{#script_url#}{literal}Search/';
                url += $("#search_form input[name='search']").val() + '.html';
                $('#search_form').attr('action', url);
            });*/

            
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
                <img src="{#img_url#}test_banner.png" alt=""/>
            </div>
            <div class="clear"></div>

        </div>
        <div id="menu">
            <ul>
                <li {if $seo_data.page_title == $html_home_page.title}class="active"{/if}><a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}">{$html_home_page.title}</a></li>
                {foreach from = $html_menus item = item}
                <li {if $seo_data.page_title == $item.title}class="active"{/if}><a href="{#script_url#}{seo_url rm=$item.seo_url}">{$item.title}</a></li>
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
            </div>
        
    </div>
</div>
</body>
</html>