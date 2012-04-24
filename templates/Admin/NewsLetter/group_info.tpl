{config_load file=templates.ini section="common" scope="global"}
<table style="text-align:left;width:100%;">
<tr>
	<td width="80">Title</td>
	<td>{$data.title}</td>
</tr>
<tr>
	<td>Users</td>
	<td>
		<div style="width: 300px; max-height: 200px; overflow-x: hidden; overflow-y: auto;">
		{foreach from=$data.users item=i}{$i.first_name} {$i.last_name}<br />{/foreach}
		</div>
	</td>
</tr>
</table>
