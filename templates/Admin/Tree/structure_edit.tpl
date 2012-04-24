{config_load file=templates.ini section="common" scope="global"}

<form name="car_model_edit" action="{#script_url#}" method="POST" >
    <fieldset name="information" id="information">
      <legend>Добавить/Изменить {$item_name}</legend>
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="action" value="update_item" />
<input type="hidden" name="sn" value="{$sn}" />
<input type="hidden" name="restaurant_id" value="{$restaurant_id}" />
<div style="display:block;height:300px;width:800px;overflow:auto;">
<div id="Content">
	<div>
		<table>
		<tr>
			<td>{$item_name}</td>
			<td><input type="text" name="model" value="{$model|escape}" title="string___Please enter {$item_name}"/></td>
		</tr>
		{*<tr>
			<td>Description</td>
			<td><textarea name="description" cols=40 rows=10>{$description|escape}</textarea></td>
		</tr>*}
		{assign var=meta_title_exist value=0}
		{foreach from=$additional_fields key=key item=item}
		{if $item.request_name == 'meta_title'}{assign var=meta_title_exist value=1}{/if}
		<tr>
			<td>{$item.name}</td>
			<td>
				{if $item.type=='textarea'}
					<textarea cols=40 rows=10 name="{$item.request_name}">{$item.value|escape}</textarea>
				{elseif $item.type=='text'}
					<input id="{$item.request_name}_id" type="text" name="{$item.request_name}" value="{$item.value|escape}" {if $item.request_name == 'meta_title'}onchange="populate_seo(true);"{/if}  /> {if $item.request_name == 'seo_url' && $meta_title_exist}<a href="javascript:void(0);" onclick="populate_seo(false);" >Auto Fill from Meta Title</a>{/if}
					
				{elseif $item.type == 'richtext'}
					<textarea cols=20 rows=40 name="{$item.request_name}"  style="height:300px;" ></textarea>
				{/if}
			</td>
		</tr>
		{/foreach}		
		</table>
	</div>
	<div style="padding:0px 0px 0px 10px;">
	<input type="button" name="save" value="Save"  class="submit-button"onclick="var ajax_rm = '{$ajax_rm}';var id = {$id};{literal}if (!validator.check('car_model_edit')) return false;Lightbox.submit_form_callback = function() {tree.refresh_menu(id,document.forms.car_model_edit.model.value);};Lightbox.submit_form(document.forms.car_model_edit,ajax_rm);{/literal}"/>
		&nbsp;
		<input type="button" name="cancel" value="Cancel" class="submit-button" onclick="Lightbox.close();" />
	</div>
</div>
</div>
</fieldset>
</form>