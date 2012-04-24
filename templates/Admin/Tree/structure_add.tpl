{config_load file=templates.ini section="common" scope="global"}
<form name="car_model_add" action="{#script_url#}" method="POST" >
<input type="hidden" name="parent_id" value="{$parent_id}" />
<input type="hidden" name="action" value="save_item" />
<input type="hidden" name="sn" value="{$sn}" />
<input type="hidden" name="restaurant_id" value="{$restaurant_id}" />
<div style="display:block;height:150px;width:600px;overflow:auto;">
<div id="Content" >
	<div style="padding:10px 0px 0px 10px;">
	{*
		{$item_name}&nbsp;<input type="text" name="model" title="string___Please enter {$item_name}"/><br />
		Description&nbsp;<textarea name="description" ></textarea>
	*}	
		<table>
		<tr>
			<td>{$item_name}</td>
			<td><input type="text" name="model"  title="string___Введите {$item_name}"/></td>
		</tr>
		{*<tr>
			<td>Description</td>
			<td><textarea cols=40 rows=10 name="description" ></textarea></td>
		</tr>*}
		{assign var=meta_title_exist value=0}
		{foreach from=$additional_fields key=key item=item}
		{if $item.request_name == 'meta_title'}{assign var=meta_title_exist value=1}{/if}
		<tr>
			<td>{$item.name}</td>
			<td>
				{if $item.type=='textarea'}
					<textarea cols=40 rows=10 name="{$item.request_name}"></textarea>
				{elseif $item.type=='text'}
					<input id="{$item.request_name}_id" type="text" name="{$item.request_name}" {if $item.request_name == 'meta_title'}onchange="populate_seo(true);"{/if} /> {if $item.request_name == 'seo_url' && $meta_title_exist}<a href="javascript:void(0);" onclick="populate_seo(false);" >Auto Fill from Meta Title</a>{/if}
				{elseif $item.type == 'richtext'}
					<textarea cols=20 rows=20 name="{$item.request_name}" style="height:300px;"></textarea>
				{/if}
			</td>
		</tr>
		{/foreach}
		</table>
	</div>
	<div style="padding:0px 0px 0px 10px;">
	{*<input type="button" name="save" value="Add" onclick="submit_form();"/>*}
	<input type="button" name="save" value="Добавить" onclick="var ajax_rm = '{$ajax_rm}';var par = {$parent_id};{literal}if (!validator.check('car_model_add')) return false;Lightbox.submit_form_callback = function(req) {tree.refresh_tree(par);};Lightbox.submit_form(document.forms.car_model_add,ajax_rm);{/literal}"/>
		&nbsp;
		<input type="button" name="cancel" value="Отмена" onclick="Lightbox.close();" />
	</div>
</div>
</div>
</form>
{*
<script type="text/javascript">

validator.add('car_model_add');
var ajax_rm =  '{$ajax_rm}';

{literal}
function submit_form()
{
	if (!validator.check('car_model_add'))	return false;
	Lightbox.submit_form_callback = function(req) {tree.refresh_tree(1);}
	Lightbox.submit_form(document.forms.car_model_add,ajax_rm);
}
{/literal}
</script>
*}
