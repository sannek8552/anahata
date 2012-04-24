{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript" src="{#js_url#}Admin/CMS/contact_helper.js">
</script>
<h2>{if $edit_data}Edit{else}Add new{/if} field to form {$contact_data.name}</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Contact_Manager"}">&larr; Back</a></div>
<div class="content-container">
<form name="contact_form" method="post" action="{#script_url#}{seo_url}">
    <fieldset name="information" id="information">
      <legend>Add Form Fields</legend>
<table>
<tr>
	<td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
	<td><strong>Field Name</strong></td>
	<td><input name="field_name" type="text" value="{$edit_data.field_name}" size="60" /></td>
</tr>
{if $edit_data.field_type=='email'}
<input type="hidden" name="field_type" value="email"/>
<input type="hidden" name="field_validation" value="email"/>
{elseif $edit_data.field_type=='name'}
	<input type="hidden" name="field_type" value="name"/>
	<input type="hidden" name="field_validation" value="name"/>
{else}
<tr>
	<td><strong>Field Type</strong></td>
	<td>
	
	
		<select name="field_type" onchange="contact_process_type_change();" id="field_type_id">
			<option value="">Select Type</option>
			<option value="text" {if $edit_data.field_type=='text'}selected{/if}>Text</option>
			<option value="checkbox" {if $edit_data.field_type=='checkbox'}selected{/if}>Checkbox</option>
			<option value="textarea" {if $edit_data.field_type=='textarea'}selected{/if}>Textarea</option>
			<option value="select" {if $edit_data.field_type=='select'}selected{/if}>Select</option>
			<option value="file" {if $edit_data.field_type=='file'}selected{/if}>File</option>
		</select>
		
		<div id="select_div_id" style="display:{if !$edit_data.answer}none{else}block{/if};">
			<div id="select_container_id">{if !$edit_data.answer}<div><input name="select_answer[]" type="text" value="" size="60" />
			</div>{else}{foreach from=$edit_data.answer item=item key=key}<div><input name="select_answer[]" type="text" value="{$item.name}" size="60" />
			</div>
			{/foreach}{/if}</div>
			<div id="select_controll_id">
			<input type="button" name="add" value="Add Choice" onclick="contact_add_choice();" />
			<input type="button" name="delete" value="Delete Choice" onclick="contact_remove_choice();" />
			</div>
		</div>
		<div id="file_div_id" style="display:{if !$edit_data.file_type}none{else}block{/if};">
			<input type="text" name="file_type" value="{$edit_data.file_type.0.name}" size="60" />
			<br/>Comma separated file extension
		</div>
			</td>
</tr>


<tr>
	<td><strong>Validation</strong></td>
	<td>
		<select name="field_validation">
			<option value="">No Validation</option>
			<option value="string" {if $edit_data.field_validation=='string'}selected{/if}>String</option>
			<option value="integer" {if $edit_data.field_validation=='integer'}selected{/if}>Integer</option>
			<option value="integer_empty" {if $edit_data.field_validation=='integer_empty'}selected{/if}>Integer or Empty</option>
			{*<option value="file" {if $edit_data.field_validation=='file'}selected{/if}>File</option>*}
		</select>	</td>
</tr>
{/if}
<tr>
	<td><strong>Error Text</strong></td>
	<td><input name="field_error" type="text" value="{$edit_data.field_error}" size="60" /></td>
</tr>
<tr>
	<td><strong>Order</strong></td>
	<td><input type="text" name="order_id" value="{$edit_data.order_id}" /></td>
</tr>
<tr>
	<td>&nbsp;{if $edit_data}<input type="hidden" name="id" value="{$edit_data.id}"/>{/if}
	<input type="hidden" name="contact_id" value="{$contact_id}"/>	</td>
	<td><input type="submit" name="save" value="Save" class="submit-button"/></td>
</tr>
</table>
</fieldset>
</form>

{*list of added fields goes here*}
<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Name</th>
          <th scope="col" nowrap="nowrap">Type</th>
          <th scope="col" nowrap="nowrap">Validation</th>
          <th scope="col" nowrap="nowrap">Error Text</th>
          <th scope="col" nowrap="nowrap">Order</th>
          <th scope="col" nowrap="nowrap">Functions</th>          
        </tr>
      </thead>
{foreach from=$fields item=item key=key}
<tr>
	<td>{$item.field_name}</td>
	<td>{if $item.field_type=='text'}Text{elseif $item.field_type=='checkbox'}Checkbox{elseif $item.field_type=='textarea'}Textarea{elseif $item.field_type=='select'}Select{elseif $item.field_type=='email'}Email{elseif $item.field_type=='file'}File{elseif $item.field_type=='name'}Name{/if}</td>
	<td>{$item.field_validation}</td>
	<td>{$item.field_error}</td>
	<td>{$item.order_id}</td>
  	<td>
		<a title="Edit" href="{#script_url#}{seo_url param1=$contact_id param2="edit" param3=$item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
		{if $item.field_type!='email' && $item.field_type != 'name'}
			<a title="Delete" href="{#script_url#}{seo_url param1=$contact_id param2="delete" param3=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>
		{/if}
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
{*end of list*}