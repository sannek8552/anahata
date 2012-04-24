{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript">
    {literal}
    function check_file(name)
    {
        var extensions = new Array('jpg', 'jpeg', 'gif', 'png')
        var re = /.+\.(\S+)$/;
        result = re.exec(name);
        flag = false;
        for (var i = 0;i < extensions.length; i ++)
        {
            if(result[result.length-1].toLowerCase() == extensions[i])
            {
                $('options_id').style.display = '';
                flag = true;
                break;
            }
        }
        if(!flag)
        {
            $('options_id').style.display = 'none';
            $('sizes_id').style.display = 'none';
            $('width_value_id').value = 1;
            $('heigth_value_id').value = 1;
        }
    }
    function visible_sizes()
    {
        if($('thumb_type_id').value == 'width')
        {
            $('sizes_id').style.display = '';
            $('height_id').style.display = 'none';
            $('width_value_id').value = '';
            $('height_value_id').value = 1;
        }
        else if ($('thumb_type_id').value == 'height_width' || $('thumb_type_id').value == 'crop')
        {
            $('sizes_id').style.display = '';
            $('height_id').style.display = '';
            $('width_value_id').value = '';
            $('heigth_value_id').value = '';
        }
        else
        {
            $('sizes_id').style.display = 'none';
            $('width_value_id').value = 1;
            $('heigth_value_id').value = 1;
        }
    }
    {/literal}
</script>
<h2>File Manager</h2>
<form action="{#script_url#}{seo_url}" method="post" enctype="multipart/form-data" name="frm">
    <fieldset name="information" id="information">
      <legend>Upload File</legend>
<table>
	
<tr>
	<td><strong>Select File:</strong></td>
        <td><input type="file" name="new_file" onchange="check_file(this.value);" /></td>
</tr>
<tr style="display:none;" id="options_id">
    <td>
        <strong>Options:</strong>
    </td>
    <td>
        <select name="thumb_type" id="thumb_type_id" onchange="visible_sizes();">
            <option value="">Please Select</option>
            <option value="width">Width</option>
            <option value="height_width">Height Width</option>
            <option value="crop" >Crop</option>
        </select>
    </td>
</tr>
<tr style="display:none;vertical-align:top;" id="sizes_id">
    <td>
        <strong>Sizes:</strong>
    </td>
    <td>
        <div id="width_id">Width:&nbsp; <input type="text" name="width" id="width_value_id" title="integer___<br/>Please enter value" value="1" /></div><div style="display:none;" id="height_id"/>Height: <input type="text" name="height" id="heigth_value_id" title="integer___<br/>Please enter value" value="1"/></div>
    </td>
</tr>
<tr>
	<td><input type="hidden" name="change_path" value="{$cur_path}"/>&nbsp;</td>
	<td><input type="submit" name="save_file" value="Save"  class="submit-button"/></td>
</tr>
</table>
</fieldset>
</form>

<form method='post' action="{#script_url#}{seo_url}">
<table>
<tr>
	<td colspan="2"><h1>{if $edit_from}Edit{else}Create new{/if} {if $edit_from_file}file{else}folder{/if}</h1></td>
</tr>
{if $folder_exists}
<tr>
	<td colspan="2" style="color:red;">Folder already exists</td>
</tr>
{/if}
<tr>
	<td>{if $edit_from_file}File{else}Folder{/if} Name</td>
	<td><input name="new_folder" type="text" value="{$edit_from}" size="40" /></td>
</tr>
<tr>
	<td>&nbsp;<input type="hidden" name="change_path" value="{$cur_path}"/>
	{if $edit_from}<input type="hidden" name="edit_from" value="{$edit_from}"/>{/if}
	</td>
	<td><input type="submit" name="save_folder" value="Save" class="submit-button"/></td>
</tr>
</table>
</form>
<div>
	Now at: <a href="{#script_url#}{seo_url}">root</a> 
	{if $cur_path_split}&gt;{/if} {foreach from=$cur_path_split item=item key=key name='p_f'}
	
	<a href="#" onclick="$('path_form').elements['change_path'].value='{$item.link}';$('path_form').submit();return false;">{$item.name}</a> {if !$smarty.foreach.p_f.last}&gt;{/if}
	
	{/foreach}
</div>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="3"><h2>Content</h2></td>
</tr>
{foreach from=$dirs item=item key=key}
<tr>
	<td><a href="#" onclick="$('path_form').elements['change_path'].value+='{$item}';$('path_form').submit();return false;">{$item}</a></td>
	<td width="100" align="right"><a href="#" onclick="$('path_form').elements['action'].value='edit';$('path_form').elements['action_item'].value='{$item}';$('path_form').submit();return false;" title="Folder Edit"><img border="none" src="{#admin_img_url#}folder_edit.png" alt="Folder Edit"/></a>
	<a href="#" onclick="{literal}if(!confirm('Are you sure?')){return false;};{/literal}$('path_form').elements['action'].value='delete';$('path_form').elements['action_item'].value='{$item}';$('path_form').submit();return false;" title="Folder Delete"><img border="none" src="{#admin_img_url#}folder_delete.png" alt="Folder Delete" /></a></td>
	<td>&nbsp;</td>
</tr>
{/foreach}
{foreach from=$files item=item key=key}
<tr>
	<td><a href="{#domain_name#}{#script_url#}{$prefix}{$item}">{$item}</a></td>
	<td align="right">
	<a href="#" onclick="$('path_form').elements['action'].value='edit';$('path_form').elements['action_item'].value='{$item}';$('path_form').submit();return false;" title="Edit"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
	<a href="#" onclick="{literal}if(!confirm('Are you sure?')){return false;};{/literal}$('path_form').elements['action'].value='delete';$('path_form').elements['action_item'].value='{$item}';$('path_form').submit();return false;" title="Delete"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a></td>
	<td>&nbsp;{#domain_name#}{#script_url#}{$prefix}{$item}</td>
</tr>
{/foreach}
</table>

<form action="{#script_url#}{seo_url}" method="post" id="path_form">
<input type="hidden" name="change_path" value="{$cur_path}" />
<input type="hidden" name="action" value="" />
<input type="hidden" name="action_item" value="" />
</form>

<script type="text/javascript">
    validator.add('frm');
</script>