{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Special Manager</h2>  
  <a href="{#script_url#}{seo_url rm="AdminSpecial" param1="category"}" class="submit-button"> Add Special by Product Categories  &minus;&gt;</a>
<fieldset name="information" id="information">
      <legend>Products</legend>  
  <form name="add_special" method="post" action="{#script_url#}{seo_url rm="AdminSpecial"}" >
  	<input type="hidden" name="type" value="product" />
  	<table>
  		<tr>
  			<td valign="top"><b>All Products</b></td>
<td colspan="3">
  				<select multiple name="products[]" style="width:100%;">
  				{foreach from=$categories item=category key=ckey}
  					<option value="cat_{$ckey}" disabled>{$category}</option>
	  				{foreach from=$products item=item key=key}
		  				{if $item.category_id == $ckey}
		  					<option value="{$item.id}" {if $selected_products[$item.id]}selected{/if}>
		  						&nbsp;&nbsp;{$item.name} ({$item.price|money}) ID {$item.number} 
		  						{if $category_specials[$item.category_id]}	
		  							&nbsp;Current Special: {if $category_specials[$item.category_id].type == 'price'}{$category_specials[$item.category_id].amount|money}{else}{$category_specials[$item.category_id].amount}%{/if} off
	  								&nbsp; 
	  								{if $category_specials[$item.category_id].available_date}Available after {$category_specials[$item.category_id].available_date|date_output:"d.m.Y"}{/if} 
	  								{if $category_specials[$item.category_id].expiry_date}Expiry after {$category_specials[$item.category_id].expiry_date|date_output:"d.m.Y"}{/if} 	  						
		  						
		  						{else if $specials[$item.id]}
		  							&nbsp;Current Special: {if $specials[$item.id].type == 'price'}{$specials[$item.id].amount|money}{else}{$specials[$item.id].amount}%{/if} off
		  							&nbsp; 
		  							{if $specials[$item.id].available_date}Available after {$specials[$item.id].available_date|date_output:"d.m.Y"}{/if} 
		  							{if $specials[$item.id].expiry_date}Expiry after {$specials[$item.id].expiry_date|date_output:"d.m.Y"}{/if} 
		  						{/if}
		  					</option>
		  				{/if}
	  				{/foreach}
	  			{/foreach}
  				</select>
  			</td>
  		</tr>
  		{*specials module fields*}    
    		{include file='Admin/Special/special_product.tpl'}       
    	{*end of specials module fields*}
    	
    	<tr>    		
    		<td><input type="submit" class="submit-button" name="save" value="Save" /></td>
    		<td><input type="submit"class="submit-button" name="remove" value="Remove" /></td>
    	</tr>
  	</table>
  </form>  </fieldset>
</div>