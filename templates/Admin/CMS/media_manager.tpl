{config_load file=templates.ini section="common" scope="global"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{literal}
	<title>{#media_manager.title}</title>{/literal}
	<script type="text/javascript" src="{#js_url#}mootools.v1.11.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/utils/mctabs.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/utils/form_utils.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/utils/validate.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/utils/editable_selects.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/plugins/media_manager/js/media_manager.js"></script>
	{*if $uploaded}
	<script type="text/javascript">
	
	insert_image('{#domain_name#}{#script_url#}{$uploaded}');
	</script>
	{/if*}
</head>

<body id="table" style="display: none">	
		<div class="tabs">
			<ul>
				<li id="upload_tab" {if $current_tab == 'upload'}class="current"{/if}>
					<span>
						{literal}<a href="javascript:mcTabs.displayTab('upload_tab','upload_panel');" onmousedown="return false;">Upload</a>{/literal}
					</span>
				</li>
				<li id="list_tab"  {if $current_tab == 'list'}class="current"{/if}>
					<span>
						{literal}<a href="javascript:mcTabs.displayTab('list_tab','list_panel');" onmousedown="return false;">List</a>{/literal}
					</span>
				</li>
				<li id="embed_tab" {if $current_tab == 'embed'}class="current"{/if}>
					<span>
						{literal}<a href="javascript:mcTabs.displayTab('embed_tab','embed_panel');" onmousedown="return false;">Embed</a>{/literal}
					</span>
				</li>
			</ul>
		</div>
		<div class="panel_wrapper">			
			<div id="upload_panel" class="panel {if $current_tab == 'upload'}current{/if}" style="height:500px;">
			<form enctype="multipart/form-data" method="post" action="{#script_url#}{seo_url rm=media_manager}" name="upload_form" id="upload_form_id">
				<fieldset>
					<legend>Upload</legend>
					  <table border="0" cellpadding="4" cellspacing="0" width="100%">
					  <tr>
					  	<td>
					  		<input type="file" name="upload_file" onchange="file_selected();"/>
					  		<div id="message">
					  		{$error_message}
					  		</div>
					  	</td>					  
					  </table>
				</fieldset>
				{if $filename}
				<fieldset style="border:1px solid blue;">
					<legend>{if $image}After a file has been uploaded, you can add titles and descriptions.{else}File Uploaded{/if}</legend>
					<input type="hidden" name="id" value="{$id}">
					<table width="100%">
						<tr>
							<td width="120">
							{if $images}
								<img src="{#script_url#}file_storage/100_{$filename}">
							{elseif $file_types[$file_info.mime]}
								<img src="{#img_url#}file_types/{$file_types[$file_info.mime]}">
							{else}
								<img src="{#img_url#}file_types/file.png">
							{/if}
							</td>
							<td>
								<p>{$filename}</p>
								<p>{$file_info.mime}</p>
							</td>
						</tr>
						{if $image}
						<tr>
							<td width="120">
								Title
							</td>
							<td>
								<input type="text" name="title" style="width:100%;" value="{$title}">
							</td>
						</tr>
						<tr>
							<td width="120">
								Caption
							</td>
							<td>
								<input type="text" name="caption" style="width:100%;" value="{$caption}">
								<small>Also used as alternate text for the image</small>
							</td>
						</tr>
						<tr>
							<td width="120">
								Description
							</td>
							<td>
								<textarea name="description" style="width:100%;">{$description}</textarea>
							</td>
						</tr>
						<tr>
							<td width="120" valign="top">
								Link URL
							</td>
							<td>
								<input type="text" name="url" style="width:100%;" value="{$url}">
							</td>
						</tr>
						<tr>
							<td width="120">
								Alignment
							</td>
							<td>
								<input type="radio" name="alignment" value="none" checked>None
								<input type="radio" name="alignment" value="left" {if $alignment=='left'}checked{/if}>Left
								<input type="radio" name="alignment" value="middle" {if $alignment=='middle'}checked{/if}>Center
								<input type="radio" name="alignment" value="right" {if $alignment=='right'}checked{/if}>Right
							</td>
						</tr>
						<tr>
							<td width="120">
								Size
							</td>
							<td>
								{foreach from=$images item=im}
								<div style="float:left;width:25%;"><input type="radio" name="size" value="{$im.key}" {if $size==$im.key}checked{/if}>({$im[0]}x{$im[1]})</div>
								{/foreach}		
							</td>
						</tr>
						{/if}
						<tr>
							<td width="120"></td>
							<td></td>
						</tr>
					</table>
				</fieldset>
				{*<input type="button" value="Delete" class="button" style="float:right;">*}
				<input type="button" value="Insert" class="button" style="float:right;"  onclick="{if $image}insert_image('{#script_url#}file_storage/','{$filename}','upload_form_id'){else}insert_file('{#script_url#}file_storage/','{$filename}','{#img_url#}file_types/{if $file_types[$file_info.mime]}{$file_types[$file_info.mime]}{else}file.png{/if}'){/if}">
				{if $image}<input type="submit" name="save" value="Save changes" class="button" style="float:right;">{/if}
				{/if}
				{if $error}
				<span class="error">{$error}</span>
				{/if}
			</form>
			</div>

			<div id="list_panel" class="panel {if $current_tab == 'list'}current{/if}" style="height:540px;overflow:auto;">
				<form enctype="multipart/form-data" method="post" action="{#script_url#}{seo_url}" id="upload_form_id_{$i.id}">
					<select name="type" style="float:right;" onchange="submit();">
						<option value="">all</option>
						<option value="images" {if $type=='images'}selected{/if}>images</option>
						<option value="music" {if $type=='music'}selected{/if}>music</option>
						<option value="video" {if $type=='video'}selected{/if}>video</option>
						<option value="files" {if $type=='files'}selected{/if}>files</option>
					</select>
				</form>
				<div style="clear:both;"></div>
				<fieldset>
					<legend>Media Library</legend>
					
					<table border="0" cellpadding="4" cellspacing="0" width="100%">
					{foreach from=$items item=i}
					<tr>
						<td width="60">
							{if $i.images}
							<img src="{#script_url#}file_storage/100_{$i.filename}" onclick="toggle('{$i.id}')"  id="thumb_{$i.id}" alt="click here" style="cursor:pointer;width:48px;">
							{elseif $file_types[$i.type]}
							<img src="{#img_url#}file_types/{$file_types[$i.type]}" id="thumb_{$i.id}">
							{else}
							<img src="{#img_url#}file_types/file.png" id="thumb_{$i.id}">
							{/if}
						</td>
						<td valign="top">
							<p>{$i.filename}</p>
						</td>
						<td width="200">
							<form enctype="multipart/form-data" method="post" action="{#script_url#}{seo_url}" id="upload_form_id_{$i.id}">
								<input type="hidden" name="id" value="{$i.id}">
								<input type="submit" value="Delete" name="delete" class="button" onclick="return confirm('Are you sure?');">
								{if $i.images}
								<input type="button" value="Insert" class="button" onclick="insert_image('{#script_url#}file_storage/','{$i.filename}','upload_form_id_{$i.id}')">
								{elseif $file_types[$i.type]}
								<input type="button" value="Insert" class="button" onclick="insert_file('{#script_url#}file_storage/','{$i.filename}','{#img_url#}file_types/{$file_types[$i.type]}')">
								{else}
								<input type="button" value="Insert" class="button" onclick="insert_file('{#script_url#}file_storage/','{$i.filename}','{#img_url#}file_types/file.png')">
								{/if}
							</form>
						</td>
					</tr>
					<tr id="details_{$i.id}" style="display:none;">
						<td colspan="3">
							<form enctype="multipart/form-data" method="post" action="{#script_url#}{seo_url}" id="upload_form_id_{$i.id}">
							<input type="hidden" name="id" value="{$i.id}">
							<table width="100%">
							{if $i.images}
							<tr>
								<td width="120">
									Title
								</td>
								<td>
									<input type="text" name="title" style="width:100%;" value="{$i.title}">
								</td>
							</tr>
							<tr>
								<td width="120">
									Caption
								</td>
								<td>
									<input type="text" name="caption" style="width:100%;" value="{$i.caption}">
									<small>Also used as alternate text for the image</small>
								</td>
							</tr>
							<tr>
								<td width="120">
									Description
								</td>
								<td>
									<textarea name="description" style="width:100%;">{$i.description}</textarea>
								</td>
							</tr>
							<tr>
								<td width="120" valign="top">
									Link URL
								</td>
								<td>
									<input type="text" name="url" style="width:100%;" value="{$i.url}">									
								</td>
							</tr>
							<tr>
								<td width="120">
									Alignment
								</td>
								<td>
									<input type="radio" name="alignment" value="none" checked>None
									<input type="radio" name="alignment" value="left" {if $i.alignment=='left'}checked{/if}>Left
									<input type="radio" name="alignment" value="middle" {if $i.alignment=='middle'}checked{/if}>Center
									<input type="radio" name="alignment" value="right" {if $i.alignment=='right'}checked{/if}>Right
								</td>
							</tr>
							<tr>
								<td width="120">
									Size
								</td>
								<td>
									{foreach from=$i.images item=im}
									<div style="float:left;width:25%;"><input type="radio" name="size" value="{$im.key}" checked>({$im[0]}x{$im[1]})</div>
									{/foreach}
								</td>
							</tr>							
							<tr>
								<td colspan="2">									
									<input type="submit" name="save" value="Save changes" class="button" style="float:right;">
								</td>
							</tr>
							{/if}
							</table>
							</form>
						</td>
					</tr>
					<tr>
						<td colspan="3" style="border-top:1px solid #999;padding:0;"></td>
					</tr>
					{foreachelse}
					<tr>
						<td colspan="3">Nothing yet</td>
					</tr>
					{/foreach}
					</table>
				</fieldset>
			</div>
			<div id="embed_panel" class="panel {if $current_tab == 'embed'}current{/if}" style="height:540px;overflow:auto;">
				<fieldset>
					<legend>Embed</legend>
					  <table border="0" cellpadding="4" cellspacing="0" width="100%">
					  <tr>
					  	<td>
					  		<textarea style="width:550px;height:60px;" name="embed" id="embed_input"></textarea><br/>
					  		<input type="button" name="submit_embed" value="Insert" onclick="insert_embed();">
					  		<span id="embed_message"></span>
					  	</td>
					  </table>
				</fieldset>
			</div>
		</div>
		<div class="mceActionPanel">
			<div style="float: left"></div>
			<div style="float: right">
				<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
			</div>
		</div>
</body>
</html>
{literal}
<script type="text/javascript">
	function toggle(id,zoom)
	{
		if ($('details_'+id).getStyle('display') == 'none')
		{
			$('details_'+id).setStyle('display','');
			if (zoom != 1) $('thumb_'+id).setStyle('width','100px');
		}
		else 
		{
			$('details_'+id).setStyle('display','none');
			$('thumb_'+id).setStyle('width','48px');
		}
	}
	
	function file_selected()
	{
		$('message').innerHTML = 'Uploading started...';
		document.forms['upload_form'].submit();
	}
</script>
{/literal}