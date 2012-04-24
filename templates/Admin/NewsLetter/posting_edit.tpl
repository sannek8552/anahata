{config_load file=templates.ini section="common" scope="global"}
{if $saved}Successfully saved!{else}
<form id="edit_form" action="javascript:void(0);" method="post">
<input type="text" style="display: none;" />

<table style="text-align: left; width: 100%;">
{if $err}<tr><td colspan="2" align="center" class="required_class">Please check marked fields</td></tr>{/if}

<tr>
	<td{if $err.title}class="required_class"{/if} width="120">Title</td>
	<td><input type="text" name="title" value="{$data.title}" /></td>
</tr>

<tr>
    <td{if $err.groups}class="required_class"{/if}>Groups
        {*<input type="radio" name="type" value="group" style="width:20px" checked  />*}

        </td>
	<td>
		<select name="groups" multiple style="width: auto;">
		{foreach from=$groups item=i}
			 <option value='{$i.id}'{if $data.groups[$i.id]}selected{/if}>{$i.title}</option>
		{/foreach}
		</select>
	</td>
</tr>

{*<tr>
	<td
            {if $err.method_id}class="required_class"{/if}>Statuses
            <input type="radio" name="type" value="status" style="width:20px" {if $data.type=="status"}checked{/if}/>
        </td>
	<td>
		<select name="statuses" multiple style="width: auto;">
		{foreach from=$statuses item=status}
			 <option value='{$status.id}'{if $data.statuses[$status.id]}selected{/if}>{$status.title}</option>
		{/foreach}
		</select>
            
	</td>
</tr>
<tr>
	<td
            {if $err.method_id}class="required_class"{/if}>Contacts
            <input type="radio" name="type" value="contact" style="width:20px" {if $data.type=="contact"}checked{/if}/>
        </td>
	<td>
		<select name="contacts" multiple style="width: auto;">
		{foreach from=$contacts item=contact}
			 <option value='{$contact.id}'{if $data.contacts[$contact.id]}selected{/if}>{$contact.subject}</option>
		{/foreach}
		</select>

	</td>
</tr>
*}
<tr>
	<td{if $err.method_id}class="required_class"{/if}>Method</td>
	<td>
		<select name="method_id" style="width: auto;">
		{foreach from=$methods item=i}
			 <option value='{$i.id}'{if $data.method_id==$i.id}selected{/if}>{$i.title}</option>
		{/foreach}
		</select>
	</td>
</tr>

<tr>
	<td{if $err.mail_id}class="required_class"{/if}>Mail</td>
	<td>
		<select name="mail_id" style="width: auto;">
		{foreach from=$mails item=i}
			 <option value='{$i.id}'{if $data.mail_id==$i.id}selected{/if}>{$i.title}</option>
		{/foreach}
		</select>
	</td>
</tr>

<tr>
        <td>Date</td>
	<td>
		Date:
                    {*<!--{html_select_date time=$data.date_time all_extra="class=date_time"}-->*}
                    <input readonly type="text" style="width:auto;" name="date" id="date_id" value="{if $data.date_time}{$data.date_time|date_format:"%d/%m/%Y"}{else}{$smarty.now|date_format:"%d/%m/%Y"}{/if}" />
                    <img style="vertical-align: middle;" src="{#js_url#}jscalendar/jscalendar.gif" alt="choose date" id="date_img" border="0"/><br/>
                Time:
                    {html_select_time display_seconds=false time=$data.date_time all_extra="class=date_time"}
        
	

	
	
	
	
	
	
        
	</td>
</tr>

<tr>
	<td><input type="hidden" name="item_id" value="{$data.id}" /></td>
	<td><input type="button" style="width: auto;" name="save" value="Save" onclick="nlposting.save_edit('edit_form');" /></td>
</tr>

</table>

</form>
{/if}
