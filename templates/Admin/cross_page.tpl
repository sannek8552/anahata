{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Cross page Manager</h2> 
 
<fieldset name="information" id="information">
      <legend>Pages</legend>
  <form name="add_special" method="post" action="{#script_url#}{seo_url rm="AdminCrossPage"}" >
  	<input type="hidden" name="type" value="product" />
  	<table>
  		<tr>
  			<td valign="top"><b>All Pages</b></td>
			<td colspan="3">
  				<select multiple name="pages[]" style="width:100%;">
  				{foreach from=$pages item=page key=key}
                                <option {if $key != '1'}style="padding-left:10px;"{/if} value="{$key}">
                                    {$page}
                                    {if $cross_pages[$key]}
                                </option>
                                <option disabled style="padding-left:20px;">
                                    {foreach from=$cross_pages[$key] item=citem key=cskey name="cross_for"}
                                            {if $pages[$citem.cross_page_id]}
                                                    {$pages[$citem.cross_page_id]}
                                            {/if}
                                            {if !$smarty.foreach.cross_for.last},{/if}
                                    {/foreach}
                                    {/if}
                                </option>
	  			{/foreach}
  				</select>
  			</td>
  		</tr>
  		<tr>
  			<td width="150" valign="top"><strong>Pages to Cross</strong></td>
<td>
  				<select multiple name="cross_pages[]" style="width:100%;">
  				{foreach from=$pages item=page key=key}
                                <option {if $key != '1'}style="padding-left:10px;"{/if} value="{$key}">
                                    {$page}
                                </option>
	  			{/foreach}
  				</select>
  			</td>
  		</tr>
    	<tr>
    		<td></td>
    		<td>
                    <input type="submit" name="save" value="Save" class="submit-button" />
                    <input type="submit" name="clear" value="Clear" class="submit-button" />
                </td>
    	</tr>
  	</table>
  </form></fieldset>  
</div>