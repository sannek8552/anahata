{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Special Manager</h2>  
  <br />  
   <a href="{#script_url#}{seo_url rm="AdminSpecial"}">Products</a>
  <br />  
  <h3>Category Specials</h3>
  <div class="notes">
   Note that setting up special for category will overwrite all specials for products in that category
  </div>
  <form name="add_special" method="post" action="{#script_url#}{seo_url rm="AdminSpecial"}" >
  	<input type="hidden" name="type" value="category" />
  	<table>
  		<tr>
  			<td><b>Categories</b></td>
  			<td colspan="3">
  				<select multiple name="categories[]" style="width:100%;">
  				{foreach from=$categories item=category key=ckey}
  					<option value="{$ckey}" {if $selected_categories[$ckey]}selected{/if}>
  						{$category}
  						{if $category_specials[$ckey]}
	  							&nbsp;Current Special: {if $category_specials[$ckey].type == 'price'}{$category_specials[$ckey].amount|money}{else}{$category_specials[$ckey].amount}%{/if} off
	  							&nbsp; 
	  							{if $category_specials[$ckey].available_date}Available after {$category_specials[$ckey].available_date|date_output:"d.m.Y"}{/if} 
	  							{if $category_specials[$ckey].expiry_date}Expiry after {$category_specials[$ckey].expiry_date|date_output:"d.m.Y"}{/if} 
		  				{/if}
  					</option>
	  			{/foreach}
  				</select>
  			</td>
  		</tr>
  		{*specials module fields*}    
    		{include file='Admin/Special/special_product.tpl'}       
    	{*end of specials module fields*}
    	
    	<tr>    		
    		<td><input type="submit" name="save" value="Save" /></td>
    		<td><input type="submit" name="remove" value="Remove" /></td>
    	</tr>
  	</table>
  </form> 
</div>