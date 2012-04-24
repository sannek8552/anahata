{config_load file=templates.ini section="common" scope="global"}

<div class="content-container">
  <h2>Coupon Manager</h2>
  <a href="{#script_url#}{seo_url rm="AdminCoupon" param1="add"}" class="submit-button">Add new coupon</a>
  <br />  <br />
  
  <table align="left">
    {foreach from=$coupons item=item key=key}
    <tr>
      <td valign="top">
            <fieldset name="information" id="information">
    			<legend>Coupon Details</legend>
				<div class="table-list">
				<table>
			        <thead>
			            <tr>				          
				          <th scope="col" nowrap><b>Name</b></th>				          
				          <th scope="col" nowrap><b>Minimum order</b></th>
			              <th scope="col" nowrap><b>Coupon code</b></th>
				          <th scope="col" nowrap><b>Uses per coupon</b></th>
				          <th scope="col" nowrap><b>Uses per customer</b></th>
				          <th scope="col" nowrap><b>Start date</b></th>
				          <th scope="col" nowrap><b>End date</b></th>
			          </tr>
			        </thead>  
				        <tr>				          
					        <td>{$item.name}</td>
				            <td>{$item.minimum_order}</td>
				            <td>{$item.code}</td>
				            <td>{$item.uses_per_coupon}</td>
				            <td>{$item.uses_per_customer}</td>
				            <td>{$item.start_date|date_output:"d.m.Y"}</td>
				            <td>{$item.end_date|date_output:"d.m.Y"}</td>
				        </tr>	
    			</table>
    			</div>
				<div class="table-list">
				<table>
				  <tr>
				    <td nowrap="nowrap"><b>Description</b></td>
				    <td>{$item.description}</td>				    
				  </tr>		
				  <tr>
				    <td nowrap="nowrap"><b>Applied to:</b></td>
				    <td>
				    {if $item.apply_type == 'everything'}Everything in cart
				    {elseif $item.apply_type == 'category'} Category: {$categories[$item.item_id]}
				    {elseif $item.apply_type == 'product'} Product: {$products[$item.item_id].name} #{$products[$item.item_id].number} {$products[$item.item_id].price|money} <a href="{#script_url#}{seo_url rm="AdminProduct" param1="edit" param2=$item.item_id}" >View/Edit product</a>
					{else}<span class="required_class">Coupon not applied yet</span>
					{/if}
				    </td>
				  </tr>
				  <tr>
				  	<td nowrap="nowrap">
				  		<b>Coupon text</b>
				  	</td>
				  	<td>
			
			<b>Name:</b> {$item.name|escape} {if $item.apply_type == 'everything'}<b>Type:</b>{$item.apply_type}
			{elseif $item.apply_type == 'category'}
			<b>Type:</b> {$categories[$item.item_id].title|escape} category'
			{elseif $item.apply_type == 'product'}
				<b>Type:</b>{$products[$item.item_id].name|escape} product
			{/if}
			
			{if $item.type == 'amount'}
			<b>Discount:</b> {$item.amount|money}
			{else} 
			<b>Discount:</b> {$item.amount} %
			{/if}
				  	</td>
				  </tr>
				  <tr>
				    <td valign="top" nowrap="nowrap"><b>Functions</b></td>
				    <td colspan="3"><a href="{#script_url#}{seo_url rm='AdminCoupon' param1='edit' param2=$item.id}" class="submit-button">Edit</a> <a onclick="return confirm('Are you sure?');" href="{#script_url#}{seo_url rm='AdminCoupon' param1='delete' param2=$item.id}" class="submit-button">Delete</a> <a href="{#script_url#}{seo_url rm='SendCoupon' param1='registered' param2=$item.id}" class="submit-button">Send to Registered</a> <a href="{#script_url#}{seo_url rm='SendCoupon' param1='contact' param2 = $item.id}" class="submit-button">Send to Contact</a></td>
				    </tr>		  
				</table>
				</div>
			</fieldset>  
    	</td>
    </tr>
  {foreachelse}
  <tr>
  	<td colspan="100" align="center"> none coupons found</td>
  </tr>
  {/foreach}   
</div>