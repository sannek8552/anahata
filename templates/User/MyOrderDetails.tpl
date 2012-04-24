{config_load file=templates.ini section="common" scope="global"}
<div id="bodyContent">
<h1>Payment History</h1>
<div class="table-list">
<table>
<div id="inputShort">
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Client Name</th>
          <th scope="col" nowrap="nowrap">Address</th>
          <th scope="col" nowrap="nowrap">Shipping Address</th>
          <th scope="col" nowrap="nowrap">Comments</th>
          <th scope="col" nowrap="nowrap">Shipping Type</th>
          <th scope="col" nowrap="nowrap">Method</th>
          <th scope="col" nowrap="nowrap">Total</th>
          <th scope="col" nowrap="nowrap">Transaction ID</th>
          <th scope="col" nowrap="nowrap">Date</th>         
        </tr>
      </thead>
</div>
<tr>
	<td>{$data.client_name}</td>
	<td><b>Address</b>: {$data.address}<br/>
		<b>Address 2</b>: {$data.address2}<br/>
		<b>Suburb</b>: {$data.suburb}<br/>
		<b>State</b>: {$data.state}<br/>
		<b>Postcode</b>: {$data.postcode}<br/>
		<b>Phone</b>: {$data.phone}<br />
		{*<b>Email</b>: {$data.email}*}
	</td>
	<td><b>Address</b>: {$data.shipping_address}<br/>
		<b>Address 2</b>: {$data.shipping_address2}<br/>
		<b>Suburb</b>: {$data.shipping_suburb}<br/>
		<b>State</b>: {$data.shipping_state}<br/>
		<b>Postcode</b>: {$data.shipping_postcode}<br/>
		<b>Phone</b>: {$data.shipping_phone}
	</td>
	<td>{$data.comments|nl2br}</td>
	<td>
		{$item_shippings[$data.shipping].method} {if $item_shippings[$data.shipping].price}{$item_shippings[$data.shipping].price|money}{else}free{/if}
	</td>
	<td>{$data.method}</td>	
	<td>${$data.total}</td>
	<td>{$data.transaction_id}</td>
	<td>
		{$data.created|date_output:"d.m.Y"}
	</td>
</tr>
</table>	
{if $coupons_m}
<table width="65%">
<thead>
     <tr>
          <th align="left" nowrap="nowrap" scope="col">Discounts</th>
	</tr>
    </thead>
    
<tr>
	<td>
		Coupon
	</td>
	<td>
		Discount
	</td>
</tr>
	{foreach from = $coupons_m item = item key = key}
<tr>
	<td>
		{$item.name|escape}
	</td>
	<td>
		{$item.discount|money}
	</td>
</tr>
	{/foreach}
</table>
<br/>
{/if}

{if $data.discount_point}
<table width="65%">
	<thead>
     <tr>
          <th align="left" nowrap="nowrap" scope="col">Discount points used</th>
	</tr>
    </thead>
    <tr>
    	<td>{$data.discount_point|money}</td>
    </tr>
</table>

{/if}
<table width="60%">
<thead>
    <tr>
          <th align="left" nowrap="nowrap" scope="col">Products</th>
	</tr>
    </thead>
    <tr>
    	<td><strong>Product Name</strong></td>
   	  <td><strong>Number</strong></td>
   	  <td><strong>Price</strong></td>
   	  <td><strong>Quantity</strong></td>
    </tr>
	{foreach from=$data.products item=product key=key}	
	<tr>
		<td>
			{$products[$product.product_id].name}
		</td>
		<td>#{$products[$product.product_id].number}</td>
		<td>{$product.price|money}</td>
		<td>{$product.quantity}</td>
	</tr>
	{if $product.options}
		<tr>
			<td></td>
			<td colspan="3">
				<table> 
					<thead>
					    <tr>
				          <th align="left" nowrap="nowrap" scope="col">Options</th>
						</tr>
    				</thead>
				    <tr>
				      <td><strong>Name</strong></td>
				   	  <td><strong>Number</strong></td>
				   	  <td><strong>Price</strong></td>
				   	  <td><strong>Quantity</strong></td>
				    </tr>
					{foreach from=$product.options item=item key=k}
					<tr>						
						<td>			
							{$options[$k].name}			
						</td>
						<td>#{$options[$k].item_code}</td>
						<td>{$options[$k].price|money}</td>
						<td>{$item}</td>
					</tr>	
					{/foreach}
				</table>
			</td>
		</tr>
	{/if}
	{/foreach}
<tfoot>
<tr>
	<td colspan="100"></td>
</tr>
</tfoot>
</table>

</div></div>