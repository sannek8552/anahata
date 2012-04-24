{config_load file=templates.ini section="common" scope="global"}
<!-- Individual YUI CSS files --> 
{*<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts/reset-fonts.css"> *}

<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/treeview/assets/skins/sam/treeview.css"> 
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/menu/assets/skins/sam/menu.css"> 
<!-- Individual YUI JS files --> 
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js"></script> 
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/container/container_core-min.js"></script> 
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/menu/menu.js"></script> 
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/treeview/treeview-min.js"></script> 

<script type="text/javascript" src="{#js_url#}Admin/CMS/page_creator_new.js"></script>
<div class="Menu">
<fieldset name="information" id="information">
      <legend>Site Navigation Menu</legend>
<div id="mytreeview"></div>
</fieldset>
</div>

<div class="PageEditor">
	<div id="page_editor_div" style="display:none;">
	{include file='Admin/CMS/pages/simple_page.tpl'}
	</div>
</div>

{literal}
<style type="text/css">
.edit_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/page_edit.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}
.add_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/page_add.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}
.delete_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/page_delete.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

.publish_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/key.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

.unpublish_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/key_delete.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

.activate_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/zoom_in.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

.deactivate_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/zoom_out.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

.move_up .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/move_up.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

.move_down .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/move_down.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

.cut_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/cut.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

.paste_page .yuimenuitemlabel 
{
	padding:0 0 0 20px;
	background: url('css/images/paste.png') no-repeat;
	margin-left:5px;
	margin-right: 10px;
}

/*.delete_page .yuimenuitemlabel-selected
{
	padding:0 0 0 20px;
	background: url('css/images/page_delete.png') no-repeat;
	margin-left:10px;
	margin-right: 10px;
	border:0px solid green;
}*/
.spacer_page .yuimenuitemlabel 
{
	padding:0;
	width: 150px;
}
</style>
{/literal}

<script type="text/javascript">
var menu_tree = {$menu_tree};
</script>

<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
		mode : "exact",
		elements: "simple_module_contentid",
		theme : "advanced",
		plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,storage",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,ibrowser,storage",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		{/literal}content_css : "{#css_url#}main.css",{literal}
		theme_advanced_resizing : true,
		{/literal}
        remove_script_host : true,
        document_base_url : "{#domain_name#}{#script_url#}",
        {literal}

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		//content_css : "css/main.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js"
		
	});
{/literal}
</script>