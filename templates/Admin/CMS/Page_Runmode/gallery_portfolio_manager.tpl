{config_load file=templates.ini section="common" scope="global"}
<h2>Portfolio Gallery Manager</h2>
    <fieldset name="information" id="information">
      <legend>Add Gallery</legend>
<form name="gallery_form" method="post" action="{#script_url#}{seo_url}">

<table>

<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><strong>Gallery Name:</strong></td>
	<td><input type="text" name="name" value="{$name}" title="string___Enter Name" /></td>
</tr>
<tr>
	<td><strong>Items per page:</strong></td>
	<td><input type="text" name="items_per_page" value="{$items_per_page}" title="integer___Enter integer"/></td>
</tr>
<tr>
	<td>&nbsp;
	{if $id}<input type="hidden" name="id" value="{$id}"/>{/if}
	</td>
	<td><input type="submit" name="save" value="Save" class="submit-button"//></td>
</tr>
</table>
</form></fieldset>
<script type="text/javascript">
validator.add('gallery_form');
</script>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Gallery_Portfolio_Manager"}">Add New Gallery</a></div><br /><br />
<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Insert Code</th>
          <th scope="col" nowrap="nowrap">Name</th>
          <th scope="col" nowrap="nowrap">Items Per Page</th>
         {* <th scope="col" nowrap="nowrap">Images</th>  *}      
          <th scope="col" nowrap="nowrap">Functions</th>          
          </tr>
      </thead>
{foreach from=$gallery item=item key=key}
<tr>
	<td>[gallery_portfolio_module?section={$item.id}]</td>
	<td>{$item.name}</td>
	<td>{$item.items_per_page}</td>
	{*<td>0</td>*}
	<td><a title="Edit" href="{#script_url#}{seo_url param1='edit' param2=$item.id}"><img border="none" src="{#img_url#}edit.png" alt="Edit" /></a>
	<a title="Pictures" href="{#script_url#}{seo_url param1='picture' param2=$item.id param3='clear'}"><img border="none" src="{#img_url#}pictures.png" alt="Pictures" /></a>
    <a title="Delete" href="{#script_url#}{seo_url param1='delete' param2=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#img_url#}cross.png" alt="Delete" /></a>
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