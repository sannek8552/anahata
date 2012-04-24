{config_load file=templates.ini section="common" scope="global"}
<h2>Entries for {$faq_data.name}</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="FAQ_Manager"}">&larr; Back</a></div>
<fieldset name="information" id="information">
      <legend>FAQs</legend>
	<div id="faq_accordion">
	</div>
    </fieldset>
    
<fieldset name="information" id="information">
      <legend>Add/Edit FAQ</legend>
	<div id="faq_container">
		<div class="faq_entry">
		<strong>Topic Title:</strong>
		<input name="name_topic_title" type="text" id="topic_title" value="" size="80" />
		<br />
		<strong>FAQ Entry:</strong>		{*fceditor editor_name="faq_entry" value=""*}
		<textarea name="faq_entry" id="faq_entryid" cols="30" rows="15"></textarea>
		</div>
	</div><br />
	<input type="button" onclick="faq_add_entry();" id="faq_add_entry_id" value="Add Entry"  class="submit-button"/>
        <input type="button" name="save_all"  class="submit-button" value="Save All" onclick="faq_save();" />
    </fieldset>
		</div>
	</div>


<script type="text/javascript" src="{#js_url#}Admin/CMS/faq_helper.js"></script>
<script type="text/javascript">
var faq_section_id = {$faq_data.id};
{foreach from=$faq_entries item=item key=key}
faq_entries['{$key}'] = {literal}{{/literal}title:'{$item.title|escape}',content:'{$item.content|escape:"quotes"}', id:'{$item.id}'{literal}}{/literal};
{/foreach}
{literal}
window.addEvent('domready', function() {
	faq_rebuild_accordion();
});
tinyMCE.init({
		// General options
		mode : "textareas",
		elements: "tes",
		theme : "advanced",
		plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,storage,media_manager",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,ibrowser,storage,media_manager",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		//content_css : "css/word.css",

		relative_urls : false,
		{/literal}
		remove_script_host : true,
		document_base_url : "{#domain_name#}{#script_url#}",
		{literal}

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js"

	});

{/literal}
</script>