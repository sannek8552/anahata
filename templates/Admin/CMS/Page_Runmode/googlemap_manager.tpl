{config_load file=templates.ini section="common" scope="global"}
<h2>{if $edit_data}Google Map Manager - Edit{else}Google Map Manager - Add New{/if} Map</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="GoogleMap_Manager"}">Add New Map</a></div>
<form method="post" action="{#script_url#}{seo_url}" name="googlemap_form">
    <fieldset name="information" id="information">
      <legend>Add New Location</legend>
<table>
<tr>
	<td colspan="2" align="center"><h1>{if $edit_data}Edit{else}Add new{/if} Map</h1></td>
</tr>
<tr>
	<td><strong>Google Key</strong></td>
	<td><input name="google_key" type="text" title="string___Enter key" value="{$edit_data.google_key}" style="width:auto;" size="90" /></td>
</tr>
<tr>
	<td><strong>Location</strong></td>
	<td><input name="location" type="text" title="string___Enter location" value="{$edit_data.location}" style="width:auto;" size="90" /></td>
</tr>
<tr>
	<td>&nbsp;{if $edit_data}<input type="hidden" name="id" value="{$edit_data.id}">{/if}</td>
	<td><input type="submit" name="save" value="Save" class="submit-button"/></td>
</tr>
</table>
</fieldset>
</form>
<script type="text/javascript">
validator.add('googlemap_form');
</script>

<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Insert Code</th>
          <th scope="col" nowrap="nowrap">Google Key</th>
          <th scope="col" nowrap="nowrap">Location</th>
          <th scope="col" nowrap="nowrap">Functions</th>
      </thead>
{foreach from=$maps item=item key=key}
<tr>
	<td>
            <p><strong>[googlemap_module?section={$item.id}]</strong></p>
            <p style="color:#FF0000;"><em>to include Street View in your form, your snippet will be:</em></p>
	  <p><strong>[googlemap_module?section={$item.id}&amp;street_view=1]</strong></p>
        </td>
	<td>{$item.google_key}</td>
	<td>{$item.location}</td>
	<td><a title="Edit" href="{#script_url#}{seo_url param1="edit" param2=$item.id}"><img border="none" src="{#admin_img_url#}edit.png" align="Edit" /></a><a href="{#script_url#}{seo_url param1="delete" param2=$item.id}" onclick="return confirm('Are you sure?');" title="Delete"><img border="none" src="{#admin_img_url#}cross.png" align="Delete" /></a></td>
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