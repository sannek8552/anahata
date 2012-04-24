{config_load file=templates.ini section="common" scope="global"}
<h2>Banner Manager</h2>
{*<div class="NewButton"><a href="{#script_url#}{seo_url rm="Gallery_Manager"}">&larr; Back</a></div>*}
	
<fieldset name="information" id="information">
<legend>{if $data.id>0}Edit Banner{else}Add New Banner{/if}</legend>

<form name="banner_form" action="{#script_url#}{seo_url rm='AdminBanner'}" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" value="save" />
<input type="hidden" name="id" value="{$data.id}" />

<table>
	<tr>
		<td><strong>Title:</strong></td>
	  <td><input type="text" name="data[title]" value="{$data.title}" /></td>
	</tr>
	<tr>
		<td><strong>Link:</strong></td>
	  <td><input type="text" name="data[link]" value="{$data.link}" /></td>
	</tr>
	<tr>
		<td><strong>Alt Text:</strong></td>
	  <td><input type="text" name="data[alt]" value="{$data.alt}" /></td>
	</tr>
	<tr>
		<td><strong>Description:</strong></td>
	  <td><textarea name="data[description]">{$data.description}</textarea></td>
	</tr>

	<tr>
		<td><strong>Image/swf file:</strong></td>
<td>
			{if $data.id>0}
				{if $swf}
					<div id="banner_{$data.id}"></div><br />
					<script type="text/javascript" src="{#js_url#}swf/swfobject.js"></script>
					<script type="text/javascript">swfobject.embedSWF("{#script_url#}upload/banner/{$data.img}", "banner_{$data.id}", "{$data.width}", "{$data.height}", "9.0.0", "{#js_url#}swf/expressInstall.swf");</script>
				{else}
					<img src="{#script_url#}upload/banner/{$data.img}" /><br />
				{/if}
			{/if}
			<input type="file" name="img" />		</td>
	</tr>

	<tr>
		<td><strong>Width:</strong></td>
	  <td><input type="text" name="data[width]" value="{$data.width}" /></td>
	</tr>
	<tr>
		<td><strong>Height:</strong></td>
	  <td><input type="text" name="data[height]" value="{$data.height}" /></td>
	</tr>

	<tr>
		<td></td>
<td>
			<input type="submit" value="Save" class="submit-button" />
			{if $data.id>0}<input type="button" value="Cancel" class="submit-button" onclick="document.location.replace('{#script_url#}{seo_url rm='AdminBanner'}');"/>{/if}		</td>
	</tr>
</table>
</form>
</fieldset>

<div class="table-list">
<table>
	<thead><tr>
		<th scope="col" nowrap="nowrap">Title</th>
		<th scope="col" nowrap="nowrap">Code</th>
		<th scope="col" nowrap="nowrap">Functions</th>		 
	</tr></thead>
{foreach from=$items item=i key=k}
	<tr>
		<td>{$i.title}</td>
		<td>[banner_module?banner={$i.id}]</td>
		<td>
			<a title="Picture Edit" href="{#script_url#}{seo_url rm='AdminBanner' param1='edit' param2=$i.id}"><img border="none" src="{#img_url#}picture_edit.png" alt="Picture Edit" /></a> 
			<a title="Picture Delete" href="{#script_url#}{seo_url rm='AdminBanner' param1='delete' param2=$i.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#img_url#}picture_delete.png" alt="Picture Delete" /></a>
		</td>
	</tr>
{/foreach}
	<tr>
		<td colspan="6">
		{foreach from=$num.prepared item=item key=key}
			<a href="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id param3='list' param4=$item}">{$item}</a>
		{/foreach}
	</td>
</tr>
	<tfoot><tr>
		<td colspan="100">&nbsp;</td>
	</tr></tfoot>
</table>
</div>
