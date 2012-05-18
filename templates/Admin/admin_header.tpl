{config_load file=templates.ini section="common" scope="global"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Панель администратора : Анахата</title>

<script type="text/javascript">
  var ajax_prefix = '{#ajax_prefix#}';
  var img_prefix = '{#admin_img_url#}';
  var js_prefix = '{#js_url#}';
  var images_prefix = '{#admin_img_url#}';
  var script_url = '{#script_url#}';
  var img_url = '{#img_url#}';
</script>

<link href="{#css_url#}admin.css" rel="stylesheet" type="text/css" />
<link href="{#css_url#}slimbox.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{#js_url#}AJAX.js"></script>
<script type="text/javascript" src="{#js_url#}mootools.v1.11.js"></script>
<script type="text/javascript" src="{#js_url#}tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{#js_url#}validator_o.js"></script>
<script type="text/javascript" src="{#js_url#}slimbox_module.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/yahoo/yahoo-min.js" ></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/dom/dom-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/event/event-min.js" ></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/element/element-min.js" ></script>
<script type="text/javascript" src="{#js_url#}jscalendar/calendar.js"></script>
<script type="text/javascript" src="{#js_url#}jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="{#js_url#}jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" href="{#js_url#}jscalendar/calendar-win2k-1.css" />

{foreach from=$js_files key=key item=item}
{if $item.f}
<script type="text/javascript" src="{$item.item}"></script>
{else}
<script type="text/javascript" src="{#js_url#}{$item.item}"></script>
{/if}
{/foreach}

{foreach from=$css_files key=key item=item}
{if $item.f}
<link href="{$item.item}" rel="stylesheet" type="text/css" />
{else}
<link href="{#js_url#}{$item.item}" rel="stylesheet" type="text/css" />
{/if}
{/foreach}

<script type="text/javascript">
{literal}
function populate_seo(auto)
{
	if ($('seo_url_id') != undefined && $('meta_title_id'))
 	{
 		if(!auto || $('seo_url_id').value.length == 0)
 		{
 			var page_title = $('meta_title_id').value;
 			page_title = page_title.replace(/\s/g,'-');
 			page_title = page_title.replace(/([^a-z|A-Z|\d|\-])/g,'');
 			$('seo_url_id').value = page_title;
 		}
 	}
}
{/literal} 
</script>

</head>
<body class="yui-skin-sam">

<script type="text/javascript" src="{#js_url#}body_blocker.js"></script>
<div id="header">

<a name="saved" href="#"></a>
  <div id="header_right">
  <a href="{#script_url#}{seo_url rm=" target="_blank"index"}">Посмотреть сайт</a> |
  <a href="{#script_url#}{seo_url rm="Logout"}">Выйти &gt;</a> </div>
  <h1>Панель администратора "Анахата"</h1>

	</div> 
	<div id="container">
		<div id="main_nav">
			<span class="preload1"></span>
			<span class="preload2"></span>
			<ul class="menu2">
				{foreach from=$menu_panel item=item key=key}
				<li class="top"><a href="{if $item.url}{#script_url#}{seo_url rm=$item.url}{else}#{/if}" id="{$item.name}" class="{if $current_menu == $item.name}current{else}top{/if}_link"><span {if $item.sub}class="down"{/if}>{$item.name}</span>
					{if $item.sub}
					<!--[if gte IE 7]><!--></a><!--<![endif]-->
					<!--[if lte IE 6]><table><tr><td><![endif]-->
					<ul class="sub">
						{foreach from=$item.sub item=sub_item key=sub_key}
						<li><a href="{if $sub_item.url}{#script_url#}{seo_url rm=$sub_item.url}{else}#{/if}">{$sub_item.name}</a></li>
						{/foreach}
					</ul>
					<!--[if lte IE 6]></td></tr></table></a><![endif]-->
					{else}
					</a>
					{/if}
				</li>
				{/foreach}
			</ul>
		</div>
	</div>
	<div id="main">{include file=$body}</div>
	<div id="footer">Версия 1.1.4 </div>
</body>
</html>