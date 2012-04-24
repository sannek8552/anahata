{config_load file=templates.ini section="common" scope="global"}
<h2>Code Manager</h2>
<form action="{#script_url#}{seo_url}" method="post">
    <fieldset name="information" id="information">
      <legend>Insert/Edit Code</legend>
<table>
<tr>
	<td>
            <strong>Title:</strong>
        </td>
        <td>
            <input type="text" name="title" value="{$edit_title}"/>
        </td>
</tr>
<tr>
	<td><strong>Text:</strong></td>
	<td><textarea cols="60" rows="20" style="width: 750px;" name="module_text">{$edit_text}</textarea></td>
</tr>
<tr>
	<td>&nbsp;<input type="hidden" name="id" value="{$edit_id}"></td><td><input type="submit" name="save" value="Save" class="submit-button"/></td>
</tr>
</table>
</fieldset>
</form>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Contact_Manager"}">Create New Entry</a></div><br /><br />
<div class="table-list">
<table>
      <thead>
        <tr>
          <th width="170" nowrap="nowrap" scope="col">Insert Code</th>
          <th scope="col" nowrap="nowrap">Title</th>
          <th scope="col" nowrap="nowrap">Text</th>
          <th width="80" nowrap="nowrap" scope="col">Functions</th>    
        </tr>
      </thead>
{foreach from=$records item=item key=key}
<tr>
	<td>[text_module?entry={$item.id}]</td>
        <td>{$item.title}</td>
	<td>{$item.module_text|truncate:250:"...":true|escape}</td>
	<td>
		<a title="Edit" href="{#script_url#}{seo_url param1='edit' param2=$item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
		<a title="Delete" href="{#script_url#}{seo_url param1='delete' param2=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>	</td>
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