<p>{config_load file=templates.ini section="common" scope="global"} </p>
<h2>Payment History</h2>
<div class="table-list">
<form name="payment" action="{#script_url#}{seo_url rm="AdminPayment"}" method="post" >
    <fieldset name="information" id="information">
  
      <legend>Filter Results by Date</legend><div id="selectShort">  
	<b>Date from:</b>&nbsp;{html_select_date end_year="+3" field_order="DMY" prefix="from_" time=$date_from}&nbsp;to&nbsp;{html_select_date end_year="+3" field_order="DMY" prefix="to_" time=$date_to}</div>
	&nbsp;<input type="submit" name="save" class="submit-button" value="Filter" />
    </fieldset>
    
<table>
<tr></tr>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Client Name</th>
          <th scope="col" nowrap="nowrap">Address</th>
          <th scope="col" nowrap="nowrap">Shipping Address</th>
          <th scope="col" nowrap="nowrap">Comments</th>
          <th scope="col" nowrap="nowrap">Shipping Type</th>
          <th scope="col" nowrap="nowrap">Payment Method</th>
          <th scope="col" nowrap="nowrap">Total</th>
          <th scope="col" nowrap="nowrap">Transaction ID</th>
          <th scope="col" nowrap="nowrap">Date</th>    
          <th scope="col" nowrap="nowrap">Products</th>
          <th scope="col" nowrap="nowrap">Functions</th>      
        </tr>
      </thead>
{foreach from=$page item=item key=key}
<tr>
	<td>{$item.client_name}</td>
	<td><b>Address</b>: {$item.address}<br/>
		<b>Address 2</b>: {$item.address2}<br/>
		<b>Suburb</b>: {$item.suburb}<br/>
		<b>State</b>: {$item.state}<br/>
		<b>Postcode</b>: {$item.postcode}<br/>
		<b>Phone</b>: {$item.phone}<br />
		<b>Email</b>: {$item.email}<br />
		<b>Country</b>: {$countries[$item.country_id].name}        
		</td>
	<td><b>Address</b>: {$item.shipping_address}<br/>
		<b>Address 2</b>: {$item.shipping_address2}<br/>
		<b>Suburb</b>: {$item.shipping_suburb}<br/>
		<b>State</b>: {$item.shipping_state}<br/>
		<b>Postcode</b>: {$item.shipping_postcode}<br/>
		<b>Phone</b>: {$item.shipping_phone}<br />	
		<b>Country</b>: {$countries[$item.shipping_country_id].name}
	</td>
	<td>{$item.comments|nl2br}</td>
	<td>	
		{$item.shipping_info.method}  {if $item.shipping_info.price}{$item.shipping_info.price|money}{else}free{/if}
		{*{$item_shipping_list[$item.shipping].method} {if $item_shipping_list[$item.shipping].price}{$item_shipping_list[$item.shipping].price|money}{else}free{/if}*}
	</td>
	<td>{if $item.method == 'card'}Credit Card{else}{$item.method}{/if}
				
		{if $item.not_approved_points > 0}
		<br />Not approved points: {$item.not_approved_points|money}
		{/if}
		
	</td>	
	<td>${$item.total}</td>
	<td>{$item.transaction_id}</td>
	<td>
		{$item.created|date_output:"d.m.Y"}	</td>
	<td>
		<table>
	{foreach from=$item.products item=product key=key}
		<tr>							
			<td height="70">Name</td>
	    <td>
				{if $product.certificate}
					{$certificates[$product.product_id].name}
				{else}
					{$products[$product.product_id].name}
					{if $product.option}
						<br />
						{$options[$product.option_id].name}	
					{/if}
				{/if}
			</td>			
		</tr>		
	{/foreach}
		</table>	
	</td>
	<td>
		<a href="{#script_url#}{seo_url rm="PaymentDetails" param1=$item.id}" >Details</a>	
		{if $item.method == 'direct deposit' || $item.method == 'deposit'}
			{if $item.not_approved_points > 0}
					<br /><a href="{#script_url#}{seo_url rm="AdminPayment" param1="approve" param2=$item.id}" >Approve&nbsp;points</a>
			{/if}
		{/if}
	</td>
</tr>

{foreachelse}
<tr>
	<td colspan="100" align="center">No payments found</td>
</tr>
{/foreach}
{if $info.prepared}
<tfoot>
<tr>
	<td colspan="100">
	Pages:&nbsp;
	{foreach from=$info.prepared item=item key=key}
	{if $item == $info.current}<b>{$item}</b>
	{else}
	<a href="{#script_url#}{seo_url rm="AdminPayment" param1="Page" param2=$item}">{$item}</a>
	{/if}
	{/foreach}	</td>
</tr>
</tfoot>
{/if}
</table>
</form>