{config_load file=templates.ini section="common" scope="global"}
<table style="text-align:left;width:100%;">
<tr>
	<td width="120">First Name</td>
	<td>{$data.first_name}</td>
</tr>
<tr>
	<td>Last Name</td>
	<td>{$data.last_name}</td>
</tr>
<tr>
	<td>E-mail</td>
	<td>{$data.email}</td>
</tr>

<tr>
	<td>Postcode</td>
	<td>{$data.postcode}</td>
</tr>
<tr>
	<td>Letter type</td>
	<td>
		 {if $data.text_type==0}HTML{/if}
		 {if $data.text_type==1}Plain Text{/if}
	</td>
</tr>
<tr>
	<td>Groups</td>
	<td>
		{foreach from=$groups item=i}
			 {if $data.groups[$i.id]}{$i.title}<br />{/if}
		{/foreach}
	</td>
</tr>
<tr>
	<td>Unsubscribed</td>
	<td>
		{if $data.unsubscribe}Yes{else}No{/if}
	</td>
</tr>
</table>
