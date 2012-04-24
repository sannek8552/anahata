{config_load file=templates.ini section="common" scope="global"}
{if $saved}
	Successfully saved!
{else}
<form id="edit_form" action="javascript:void(0);" method="post">
<input type="text" style="display: none;" />

<table style="text-align:left;width:100%;">
{*if $err}<tr><td colspan="2" align="center" class="required_class">Please check marked fields</td></tr>{/if*}

<tr>
	<td{if $err.first_name}class="required_class"{/if} width="120">First Name</td>
	<td><input type="text" name="first_name" value="{$data.first_name}" /></td>
</tr>
<tr>
	<td {if $err.last_name}class="required_class"{/if}>Last Name</td>
	<td><input type="text" name="last_name" value="{$data.last_name}" /></td>
</tr>
<tr>
	<td{if $err.email}class="required_class"{/if}>E-mail</td>
	<td>
		<input type="text" name="email" value="{$data.email}" />
		{if $err.email_unique}<span style="color: #f00;">this e-mail alrady registered</span>{/if}
	</td>
</tr>

<tr>
	<td{if $err.postcode}class="required_class"{/if}>Postcode</td>
	<td><input type="text" name="postcode" value="{$data.postcode}" /></td>
</tr>
<tr>
	<td{if $err.text_type}class="required_class"{/if}>Letter type</td>
	<td>
		<select name="text_type" style="width: auto;">
			 <option value='0'{if $data.text_type==0} selected{/if}>HTML</option>
			 <option value='1'{if $data.text_type==1} selected{/if}>Plain Text</option>
		</select>
	</td>
</tr>
<tr>
	<td{if $err.groups}class="required_class"{/if}>Groups</td>
	<td>
		<select name="groups" multiple style="width: auto;">
		{foreach from=$groups item=i}
			 <option value='{$i.id}'{if $data.groups[$i.id]}selected{/if}>{$i.title}</option>
		{/foreach}
		</select>
	</td>
</tr>
<tr>
	<td>Unsubscribed</td>
	<td>
		<input type="checkbox" name="unsubscribe" value="1" {if $data.unsubscribe}checked{/if} style="width: auto;" />
	</td>
</tr>

<tr>
	<td><input type="hidden" name="item_id" value="{$data.id}" /></td>
	<td><input type="button" style="width: auto;" name="save" value="Save" onclick="nluser.save_edit('edit_form');" /></td>
</tr>
</table>

</form>
{/if}