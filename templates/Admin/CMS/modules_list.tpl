{config_load file=templates.ini section="common" scope="global"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{literal}
	<title>{#storage.title}</title>{/literal}
	<script type="text/javascript" src="{#js_url#}tiny_mce/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/utils/mctabs.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/utils/form_utils.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/utils/validate.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/utils/editable_selects.js"></script>
	<script type="text/javascript" src="{#js_url#}tiny_mce/plugins/storage/js/storage.js"></script>

</head>
{literal}
<body id="table" style="display: none">
	<form onsubmit="insertTable();return false;" action="#">
		<div class="tabs">
			<ul>
			{/literal}
				{foreach from=$module_list item=item key=key name="module_list"}
				<li id="{$key}_tab" {if $smarty.foreach.module_list.first}class="current"{/if}>
					<span>
						<a href="javascript:mcTabs.displayTab('{$key}_tab','{$key}_panel');" onmousedown="return false;">{$item.name}</a>
					</span>
				</li>
				{/foreach}
			
			{*	<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onmousedown="return false;">{#storage.general_tab}</a></span></li>
				<li id="advanced_tab"><span><a href="javascript:mcTabs.displayTab('advanced_tab','advanced_panel');" onmousedown="return false;">{#storage.advanced_tab}</a></span></li>*}
				
			</ul>
		</div>
		<div class="panel_wrapper">
			{foreach from=$module_list item=item key=key name="module_list"}
			<div id="{$key}_panel" class="panel {if $smarty.foreach.module_list.first}current{/if}">
				<fieldset>
					<legend>{$item.name}</legend>
                                        {if $item.name == 'Popup Page'}
                                            <script type="text/javascript" src="{#js_url#}mootools.v1.11.js"></script>
                                            {literal}
                                            <script type="text/javascript">
                                                function popup_module_fast_insert()
                                                {
                                                    code_string = '[popup_module?';

                                                    if($('page_seo').options[$('page_seo').selectedIndex].value != '')
                                                    {
                                                        code_string = code_string+'page_seo='+$('page_seo').options[$('page_seo').selectedIndex].value;
                                                    }
                                                    if($('link_text').value != '')
                                                    {
                                                        code_string = code_string+'&link_text='+$('link_text').value;
                                                    }
                                                    else
                                                    {
                                                        alert('Please enter link text');
                                                        return false;
                                                    }
                                                    if($('height').value != '')
                                                    {
                                                        code_string = code_string+'&height='+$('height').value;
                                                    }
                                                    if($('width').value != '')
                                                    {
                                                        code_string = code_string+'&width='+$('width').value;
                                                    }
                                                    code_string = code_string + ']';
                                                    insert_module(code_string);
                                                }
                                            </script>
                                            {/literal}
                                            <fieldset>
                                                <legend>Fast Insert</legend>
                                                <table width="100%">
                                                    <tr valign="top">
                                                        <td>
                                                            {if $main_page}
                                                            Seo:
                                                            <select id="page_seo">
                                                                <option value="{$main_page.seo_url}">|{$main_page.title|escape}</option>
                                                                {foreach from = $menu_list.sub item=it key=key}
                                                                    <option value="{$it.seo_url}">|{$it.prefix|escape}</option>
                                                                    {if $it.sub}
                                                                        {foreach from=$it.sub item=s_item key=s_key}
                                                                            <option value="{$s_item.seo_url}">|{$s_item.prefix|escape}</option>
                                                                            {if $s_item.sub}                                              
                                                                                {include file="Admin/menutabs.tpl" items = $s_item.sub k = $s_key}
                                                                            {/if}
                                                                        {/foreach}
                                                                    {/if}
                                                                {/foreach}
                                                            </select>
                                                            {/if}
                                                        </td>
                                                        <td>
                                                            Link Text:<input type="text" id="link_text" />
                                                        </td>
                                                        <td rowspan="2" valign="middle">
                                                            <a href="javascript:void(0);" onclick="popup_module_fast_insert();">Insert</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Height: <input type="text" style="width:40px;" value="400" id="height" />
                                                        </td>
                                                        <td>
                                                            Width: <input type="text" value="500" id="width" style="width:40px;"/>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        {/if}
					  <table border="0" cellpadding="4" cellspacing="0" width="100%">
					  <tr>
					  	<th>Code</th>
					  	<th>Description</th>
					  	<th>Insert</th>
					  </tr>
					  {foreach from=$item.entries item=e_item key=e_key}
					  <tr>
					  	<td>{$e_item.code}</td>
						<td>
						{if $e_item.escape}
							{$e_item.description|truncate:250:"...":true|escape}
						{else}
							{$e_item.description}
						{/if}
						</td>
						<td><a href="javascript:void(0);" onclick="insert_module('{$e_item.code}');">insert</a></td>
					  </tr>
					  {/foreach}
					  </table>
				</fieldset>
			</div>
			{/foreach}
		</div>

		<div class="mceActionPanel">
			<div style="float: left">
				{*<input type="submit" id="insert" name="insert" value="Insert" />*}
			</div>

			<div style="float: right">
				<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
			</div>
		</div>
	</form>
</body>
</html>
