{config_load file=templates.ini section="common" scope="global"}
<h2>Entries for {$faq_data.name}</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="FAQ_Manager"}">&larr; Back</a></div>
<fieldset name="information" id="information">
      <legend>FAQs</legend>
    
	<div id="faq_accordion">
	</div>
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
<input type="button" name="save_all"  class="submit-button" value="Save All" onclick="faq_save();"/>
    </fieldset>
		</div>
	</div>


<script type="text/javascript" src="{#js_url#}Admin/CMS/faq_helper.js"></script>
<script type="text/javascript">
var faq_section_id = {$faq_data.id};
{foreach from=$faq_entries item=item key=key}
faq_entries['{$key}'] = {literal}{{/literal}title:'{$item.title|escape}',content:'{$item.content|escape:"quotes"}' {literal}}{/literal};
{/foreach}
{literal}
window.addEvent('domready', function() {
	faq_rebuild_accordion();
});

/*tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    plugins : "ibrowser,style,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu",
    theme_advanced_buttons1_add_before : "save,separator",  
    theme_advanced_buttons1_add : "fontselect,fontsizeselect",
    theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
    theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
    theme_advanced_buttons3_add_before : "tablecontrols,separator",
    theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,ibrowser",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_path_location : "bottom",
    plugin_insertdate_dateFormat : "%Y-%m-%d",
    plugin_insertdate_timeFormat : "%H:%M:%S",
    apply_source_formatting : false,
    {/literal}
    content_css : "{#css_url#}main.css",
    {literal}
	remove_linebreaks : false,
    extended_valid_elements : "a[name|href|target|title|onclick|class],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
    
});*/

tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    plugins : "ibrowser,style,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,searchreplace,print,contextmenu,paste",
    theme_advanced_buttons1_add_before : "",  
    theme_advanced_buttons1_add : "fontselect,fontsizeselect",
    theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
    theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
    theme_advanced_buttons3_add_before : "tablecontrols,separator",
    theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,ibrowser,pastetext,pasteword,selectall",
    theme_advanced_toolbar_location : "top",
    paste_use_dialog : true,
    theme_advanced_toolbar_align : "left",
    theme_advanced_path_location : "bottom",
    plugin_insertdate_dateFormat : "%Y-%m-%d",
    plugin_insertdate_timeFormat : "%H:%M:%S",
    apply_source_formatting : true,
   
    paste_create_paragraphs : true,
	paste_create_linebreaks : true,
	paste_use_dialog : true,
	paste_auto_cleanup_on_paste : true,
	paste_convert_middot_lists : false,
	paste_unindented_list_class : "unindentedList",
	paste_convert_headers_to_strong : true,
    paste_remove_styles : false,
    paste_strip_class_attributes: 'mso',
	
    content_css: 'http://tinymce.moxiecode.com/example_data/example_word.css',
	valid_elements: "*",
    extended_valid_elements : "a[name|href|target|title|onclick|class],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],script[charset|defer|language|src|type]"
    
});

{/literal}
</script>