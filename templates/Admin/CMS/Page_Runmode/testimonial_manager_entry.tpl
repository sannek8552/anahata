{config_load file=templates.ini section="common" scope="global"}
<h2>Testimonial for {$testimonial_data.name|escape}</h2>
<input type="button" class="submit-button" value="Back" onclick="document.location='{#script_url#}{seo_url rm = Testimonial_Manager}'" /><br/>
<form action="{#script_url#}{seo_url param1 = $testimonial_data.id}" method="post" name="frm" enctype="multipart/form-data">
    <fieldset name="information" id="information">
      <legend>Add Testimonial</legend>
	<table>
            <tr>
                <td valign="top">
                    Testimonial:
                </td>
                <td>
                    <textarea name="content" id="tes" >{$data.content}</textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input type="text" title="string___<br/>Please enter name" name="name" value="{$data.name|escape}" />
                </td>
            </tr>
            <tr>
                <td>
                    Order:
                </td>
                <td>
                    <input type="text" title="integer_empty___<br/>Please enter number" name="order_no" value="{$data.order_no}" />
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">
                    <input type="hidden" value="{$data.id}" name="id" />
                </td>
                <td align="left">
                    <input type="submit" value="Save" name="send" class="submit-button"/>
                </td>
            </tr>
	</table>
    </fieldset>
</form>
<div class="table-list">
    <table>
        <thead>
            <tr>
                <th scope="col" nowrap="nowrap">Name</th>
                <th scope="col" nowrap="nowrap">Testimonial</th>
                <th scope="col" nowrap="nowrap">Order</th>
                <th scope="col" nowrap="nowrap">Functions</th>
            </tr>
        </thead>
        {foreach from = $t_entries item = item key = key}
            <tr valign="top">
                <td nowrap="nowrap">
                    {$item.name}
                </td>
                <td valign="top">
                    {$item.content}
                </td>
                <td valign="top" >
                    {$item.order_no}
                </td>
                <td valign="top" nowrap="nowrap">
                    <a title="Edit" href="{#script_url#}{seo_url param1 = $testimonial_data.id param2='edit' param3 = $item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
                    {if $item.active}
                        <a title="Deactivate" href="{#script_url#}{seo_url param1 = $testimonial_data.id param2='deactivate' param3 = $item.id}"><img border="none" src="{#admin_img_url#}page_delete.png" alt="Deactivate" /></a>
                    {else}
                        <a title="Activate" href="{#script_url#}{seo_url param1 = $testimonial_data.id param2='activate' param3 = $item.id}"><img border="none" src="{#admin_img_url#}page_add.png" alt="Activate" /></a>
                    {/if}
                    <a title="Delete" href="{#script_url#}{seo_url param1 = $testimonial_data.id param2='delete' param3 = $item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>
                </td>
            </tr>
        {/foreach}
        <tfoot>
            <tr>
                <td colspan="100">
                </td>
            </tr>
        </tfoot>
    </table>
</div>
{*foreach from = $num_pages.prepared item=item}
{if $num_pages.current==$item}
<b><a href="{#script_url#}{seo_url param1 = $testimonial_data.id param2=$item}" >{$item}</a></b>
{else}
<a href="{#script_url#}{seo_url param1 = $testimonial_data.id param2=$item}" >{$item}</a>
{/if}
{/foreach*}
<script type="text/javascript">
    validator.add("frm");
</script>
<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
		mode : "exact",
		elements: "tes",
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