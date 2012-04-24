{config_load file=templates.ini section="common" scope="global"}
<h2>Pictures for {$gallery_data.name}</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Before_After_Gallery_Portfolio_Manager"}">&larr; Back</a></div>
    <fieldset name="information" id="information">
      <legend>Add New Images</legend>
<form name="picture_form" action="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id}" enctype="multipart/form-data" method="post">
<table>
<tr>
	<td colspan="2" align="center"><h1>Pictures for {$gallery_data.name}</h1></td>
</tr>
<tr>
	<td>Name:</td>
	<td><input type="text" name="name" value="{$name}" /></td>
</tr>
<tr>
	<td>Description:</td>
	<td>
		<textarea name="description">{$description}</textarea>
	</td>
</tr>
<tr>
	<td>Before Image:</td>
	<td><input type="file" name="pic1" /></td>
</tr>
<tr>
	<td>After Image:</td>
	<td><input type="file" name="pic2" /></td>
</tr>
<tr>
	<td>Website URL:</td>
	<td><input type="text" name="url" value="{$url}"/></td>
</tr>
<tr>
	<td>Order:</td>
	<td><input type="text" name="order_no" value="{$order_no}" /></td>
</tr>
<tr>
	<td>&nbsp;{if $id}<input type="hidden" name="picture_id" value="{$id}"/>{/if}</td>
	<td><input type="submit" name="save" value="Save" class="submit-button"/></td>
</tr>
</table>
</form>
</fieldset>

<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Name</th>
          <th scope="col" nowrap="nowrap">Description</th>
          <th scope="col" nowrap="nowrap">Before</th>
         <th scope="col" nowrap="nowrap">After</th>
         <th scope="col" nowrap="nowrap">Order</th>
          <th scope="col" nowrap="nowrap">Functions</th>
           </tr>
      </thead>
      
{foreach from=$page item=item key=key}
<tr>
	<td>{$item.name}</td>
	<td>{$item.description}</td>
	<td><img src="{#script_url#}gallery/{$gallery_data.width2}_{$item.pic1}" /></td>
	<td><img src="{#script_url#}gallery/{$gallery_data.width2}_{$item.pic2}" /></td>
	<td>{$item.order_no}</td>
	<td>
		<a title="Picture Edit" href="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id param3='edit' param4=$item.id}"><img border="none" src="{#admin_img_url#}picture_edit.png" alt="Picture Edit" /></a>
		<a title="Picture Delete" href="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id param3='delete' param4=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}picture_delete.png" alt="Picture Delete" /></a>
		{*<a href="#">Disable</a>*}
	</td>
</tr>
{/foreach}
<tr>
	<td colspan="6">
	{foreach from=$num.prepared item=item key=key}
	<a href="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id param3='list' param4=$item}">{$item}</a>
	{/foreach}
	</td>
</tr>
<tfoot>
<tr>
	<td colspan="100">
</td>
</tr>
</tfoot>
</table></div>