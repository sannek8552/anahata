{config_load file=templates.ini section="common" scope="global"}
<h2>Side Box Manager</h2>
{*<div class="NewButton"><a href="{#script_url#}{seo_url rm="News_Manager"}">&larr; Back</a></div><br />*}
<form action="{#script_url#}{seo_url}" method="post" name="frm">
    <fieldset name="information" id="information">
      <legend>Add Side Box</legend>
	<table>
		<tr>
			<td align="left">
			Title:
			</td>
			<td align="left">
                            <input type="text" title="string___Please enter title" name="title" value="{$data.title}" />
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
			Text:
			</td>
			<td align="left" width="90%" >
                            <textarea name="text" id="textid" style="width: 100%;" rows="35" title="">{$data.text}</textarea>
			</td>
		</tr>
                <tr>
			<td align="left">
			Url:
			</td>
			<td align="left">
                            <select name="cms_url" >
                                <option value="0">Select...</option>
                                {foreach from=$pages item=item}
                                <option {if $item.seo_url==$data.cms_url and !empty($data.cms_url)}selected{/if} value="{$item.seo_url}">{$item.title}</option>
                                {/foreach}
                            </select><br/>
                            <input type="text" name="external_url" value="{$data.external_url}" style="width:400px;"/>
			</td>
		</tr>
                <tr>
			<td align="left">
			Active:
			</td>
			<td align="left">
                            <input type="checkbox"  {if $data.active}checked{/if} name="active" value="checked" style="width: auto; margin-left: 0px;"/>
			</td>
		</tr>
                <tr>
			<td align="left">
			Order:
			</td>
			<td align="left">
                            <input type="text" name="order_no" value="{$data.order_no}" />
			</td>
		</tr>
		<tr>
                        <td align="left" colspan="2">
                                <input type="hidden" value="{$data.id}" name="id"/>
				<input type="submit" value="Save" name="save" class="submit-button"/>
                                {*<input type="reset" value="Clear" name="clear" class="submit-button"/>*}
			</td>
		</tr>
	</table>
    </fieldset>
</form>
<div class="table-list">
<table>
    <thead>
        <tr>
            <th scope="col" nowrap="nowrap">No</th>
            <th scope="col" nowrap="nowrap" >Title</th>
            <th scope="col" nowrap="nowrap" width="600px">Text</th>
            <th scope="col" nowrap="nowrap">Status</th>
            <th scope="col" nowrap="nowrap">Functions</th>
        </tr>
    </thead>
	{foreach from = $all_data item = item key = key}
	<tr>
            <td valign="top">
		{$key+1}
            </td>
            <td valign="top">
		{$item.title}
            </td>
            <td valign="top" >
		{$item.text|truncate:250}
            </td>
            <td valign="top" >
		{if $item.active}
                    <font color="green">Active</font>
                {else}
                    <font color="red">Inactive</font>
                {/if}
            </td>
            <td valign="top">
                <a title="Edit" href="{#script_url#}{seo_url param1 = "edit" param2 = $item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
                <a title="Delete" href="{#script_url#}{seo_url param1 = "delete" param2 = $item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>
            </td>
	</tr>
	{/foreach}
<tfoot>
<tr>
	<td colspan="100"></td>
</tr>
</tfoot>
</table>
</div>
{foreach from = $num_pages.prepared item=item}
{if $num_pages.current==$item}
<b><a href="{#script_url#}{seo_url param1=$news_data.id param2=$item}" >{$item}</a></b>
{else}
<a href="{#script_url#}{seo_url param1=$news_data.id param2=$item}" >{$item}</a>
{/if}
{/foreach}
<script type="text/javascript">
 validator.add("frm");
</script>
<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
		mode : "exact",
		elements: "textid,",
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

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js"
		
	});
{/literal}
</script>