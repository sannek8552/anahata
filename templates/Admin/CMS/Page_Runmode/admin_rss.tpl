{config_load file=templates.ini section="common" scope="global"}
<h2>RSS Manager</h2>
<form name="gallery_form" method="post" action="{#script_url#}{seo_url}">
    <fieldset name="information" id="information">
      <legend>Add RSS</legend>
<table>
<tr>
	<td><strong>{$L_RSS_URL}</strong></td>
	<td>
		<input type="text" size="80" name="rss_url" value="{$rss_url}" />
	</td>
</tr>
<tr>
	<td><strong>{$L_ITEMS_PER_PAGE}</strong></td>
	<td>
		<input type="text" size="6" name="rss_list" value="{$rss_list}" />
	</td>
</tr>
<tr>
	<td><strong>{$L_LOAD_BY_AJAX}</strong></td>
	<td>
		<input type="checkbox" name="rss_ajax" id="rss_ajax_id" {if $rss_ajax}checked="checked"{/if}/>
	</td>
</tr>
<tr>
	<td><strong>{$L_SHOW_TITLE}</strong></td>
	<td>
		<input type="checkbox" name="rss_title" id="rss_title_id" {if $rss_title}checked="checked"{/if}/>
	</td>
</tr>
<tr>
	<td><strong>{$L_SHOW_PUBLISH_DATE}</strong></td>
	<td>
		<input type="checkbox" name="rss_pubdate" id="rss_pubdate_id" {if $rss_pubdate}checked="checked"{/if}/>	
	</td>
</tr>
<tr>
	<td><strong>{$L_SHOW_DESCRIPTION}</strong></td>
	<td>
		<input type="checkbox" name="rss_description" id="rss_description_id" {if $rss_description}checked="checked"{/if}/>
	</td>
</tr>
<tr>
	<td>
		&nbsp;<input type="hidden" name="id_rss" value="{$rss_id}"/>
	</td>
	<td>
		<input type="submit" name="save" value="Save" class="submit-button"/>
	</td>
</tr>
</table>
</fieldset>
</form>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Gallery_RSS"}">Add New Feed</a></div><br /><br />
<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">{$L_INSERT_CODE}</th>
          <th scope="col" nowrap="nowrap">{$L_RSS_URL}</th>          
          <th scope="col" nowrap="nowrap">{$L_ITEMS_PER_PAGE_SHORT}</th>
         <th scope="col" nowrap="nowrap">{$L_AJAX_SHORT}</th>       
          <th scope="col" nowrap="nowrap">{$L_SHOW_TITLE_SHORT}</th>          
           <th scope="col" nowrap="nowrap">{$L_SHOW_PUBLISH_DATE_SHORT}</th>
         <th scope="col" nowrap="nowrap">{$L_SHOW_DESCRIPTION_SHORT}</th>       
          <th scope="col" nowrap="nowrap">{$L_FUNCTIONS}</th>                       
          </tr>
      </thead>
	{foreach from=$data item=item key=key}
	<tr>
		<td>[feed_reader?section={$item.rss_id}]</td>
		<td>{$item.rss_url}</td>
		<td>{$item.rss_list}</td>
		<td>{if $item.rss_ajax}yes{else}no{/if}</td>
		<td>{if $item.rss_title}yes{else}no{/if}</td>
		<td>{if $item.rss_pubdate}yes{else}no{/if}</td>
		<td>{if $item.rss_description}yes{else}no{/if}</td>
		<td width="80">
<a href="{#script_url#}{seo_url param1='edit' param2=$item.rss_id}"><img border="none" src="{#admin_img_url#}edit.png" alt="{$L_EDIT}"/></a>
<a href="{#script_url#}{seo_url param1='delete' param2=$item.rss_id}" onclick="return confirm('{$L_ARE_YOU_SURE}');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>		</td>
  </tr>
	{/foreach}
  <tfoot>
<tr>
	<td colspan="100">
</td>
</tr>
</tfoot>
</table>