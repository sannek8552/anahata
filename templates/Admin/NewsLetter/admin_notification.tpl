{config_load file=templates.ini section="common" scope="global"}
Posting - <b>{$posting.title}</b> finished.<br />
time start: {$data.start_time|date_format:"%d/%m/%Y %H:%M:%S"}<br />
time end: {$data.update_time|date_format:"%d/%m/%Y %H:%M:%S"}<br />

<table border="1">
<tr>
	<th>User</th>
	<th>Email</th>
	<th>Sate</th>
</tr>
{foreach from=$users item=i}
<tr>
	<td>
		{$i.name}
	</td>
	<td>
	 	{$i.email}
	</td>
	<td>
		{if $i.status == 1}
			mailed
		{else}
			<span style="color: #f00;">not mailed</span><br />
			Error message: {$i.reason}
		{/if}
	</td>
{/foreach}
</table>
