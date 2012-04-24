{config_load file=templates.ini section="common" scope="global"}
{if $saved}
	Successfully saved!
{else}
<form id="edit_form" action="javascript:void(0);" method="post">
<input type="text" style="display: none;" />

<table style="text-align:left;width:100%;">
{if $err}<tr><td colspan="2" align="center" class="required_class">Please check marked fields</td></tr>{/if}

<tr>
	<td{if $err.title}class="required_class"{/if} width="120">Title</td>
	<td><input type="text" name="title" value="{$data.title}" /></td>
</tr>

<tr>
	<td><input type="hidden" name="item_id" value="{$data.id}" /></td>
	<td><input type="button" style="width: auto;" name="save" value="Save" onclick="nlgroup.save_edit('edit_form');" /></td>
</tr>
</table>

</form>
{/if}