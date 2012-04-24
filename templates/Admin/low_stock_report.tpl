{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Low stock report</h2>    
  <form name="filter_cat" method="post" action="{#script_url#}{seo_url rm="LowStockReport"}" >
    <fieldset name="information" id="information">
    <legend>Filter by Product Category and/or Brand</legend>
    <table>
      <tr>
        <td>
	      <select name="category_id" >
          	<option value="" >All categories</option>
			{foreach from=$categories item=item key=key}
				<option value="{$key}" {if $key == $filters.category_id.cat_id}selected{/if}>{$item}</option>
			{/foreach}
			</select>        
		</td>
		<td>
	      	<select name="brand_id" >
          		<option value="" >All brands</option>
				{foreach from=$brands item=item key=key}
				<option value="{$item.id}" {if $key == $filters.brand_id.v}selected{/if}>{$item.title}</option>
				{/foreach}
			</select>
        </td>
	    <td><input type="submit" class="submit-button" name="filter" value="Filter" /></td>
    </tr>
    </table>
    </fieldset>
  </form>
  <table align="left" width="100%">
  <tr>
      <td valign="top">            
				<div class="table-list">
					<table>
				        <thead>
				            <tr>
					          <th scope="col" nowrap width="300"><b>Categories</b></th>					      
					          <th scope="col" nowrap width="200"><b>Name</b></th>				          
					          <th scope="col" nowrap width="50"><b>Quantity</b></th>
					          <th scope="col" nowrap width="50"><b>Inactive</b></th>
					          <th scope="col" nowrap width="50"><b>Action</b></th>
				          </tr>
				        </thead> 
    					{foreach from=$products item=item key=key}
    
					        <tr>
					          <td valign="top">
					          	{foreach from=$category_product[$item.id] item=cat key=cat_id}
					          		{$categories[$cat_id]}<br />
					          	{/foreach}
					          </td>						    
						        <td>
						        	{$item.name}
						        	{if $item.option_name}
					        			<br /><b>Option: {$item.option_name}</b>
					        		{/if}
						        </td>
					            <td>
					            	{if $item.option_name}
					            		{if $item.option_quantity == 0}
					            			<span class="required_class">{$item.option_quantity}</span>
					            		{else}
					            			{$item.option_quantity}
					            		{/if}
					            	{else}
					            		{if $item.quantity == 0}
					            			<span class="required_class">{$item.quantity}</span>
					            		{else}
					            			{$item.quantity}
					            		{/if}
					            	{/if}	
					            </td>
					            <td>{if $item.inactive == 1}Yes{else}No{/if}</td>
					            <td><a href="{#script_url#}{seo_url rm='AdminProduct' param1='edit' param2=$item.id}" class="submit-button">Edit</a></td>
					        </tr>		    			
  						{/foreach}
  						</table>
    			</div>
   		
    	</td>
    </tr>
  <tfoot>
    <tr>
      <th colspan="5" align="left" scope="row"> {foreach from=$pages_info.prepared item=item key=key}
        {if $item == $pages_info.current} <b>{$item}</b> {else} <a href="{#script_url#}{seo_url rm='LowStockReport' param1='page' param2=$item}">{$item}</a>
        {/if}
        {/foreach} </th>
    </tr>
  </tfoot>
</table>
</div>
