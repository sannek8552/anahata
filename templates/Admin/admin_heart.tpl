{config_load file=templates.ini section="common" scope="global"}

<form action="{#script_url#}{seo_url rm="AdminHeart"}" method="post">
<table>
	<tr>
		<td>
		{*<textarea name="heart" class="textarea" >{$heart}</textarea>*}
		{*
			{if $heart != ''}
		    {fceditor_exact editor_name="heart" value=$heart   class="textarea"}
		    {else}
		    {fceditor_exact editor_name="heart" value=""   class="textarea"}
		    {/if}		
		  *}
		  <textarea id="simple_module_contentid" name="heart" >{$heart}</textarea> 
			
		</td>
	</tr>
	<tr>
		<td><input type="submit" name="save" value="Save" /></td>
	</tr>
</table>
</form>

<table>
	<tr>
		<td>How it looks at site</td>
	</tr>	
	<tr>
		<td>
			<div class="textarea">{$heart}</div>
		</td>
	</tr>
</table>

{*fceditor_init*}


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
		{/literal}content_css : "{#css_url#}mce.css",{literal}
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