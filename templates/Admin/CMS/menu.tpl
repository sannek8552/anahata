{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript">
var tree = new Array();
</script>
<script type="text/javascript" src="{#js_url#}Admin/CMS/cms_actions.js"></script>
<script type="text/javascript" src="{#js_url#}Admin/CMS/page_creator.js"></script>
<script type="text/javascript" src="{#js_url#}Admin/CMS/tree_module.js"></script>
<script type="text/javascript" src="{#js_url#}Admin/CMS/faq_helper.js"></script>

<div id="menu_div">
	<div id="droot_div" >
	</div>
</div>
<div id="outer_div">
	<div id="page_master_div" style="display:none;">
	</div>
	<div id="page_editor_div" style="display:none;">
	{include file='Admin/CMS/pages/simple_page.tpl'}
	</div>
</div>

<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
		mode : "exact",
		elements: "simple_module_contentid",
		theme : "advanced",
		plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,ibrowser",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		{/literal}content_css : "{#css_url#}style.css",{literal}
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		//content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		convert_urls : false
		
	});
{/literal}
</script>