{config_load file=templates.ini section="common" scope="global"}



<table>

<tr>

	<td>Name</td>

	<td>{$data.client_name}</td>

</tr>

<tr>

	<td>Address</td>

	<td>{$data.address}</td>

</tr>

<tr>

	<td>Address 2</td>

	<td>{$data.address2}</td>

</tr>

<tr>

	<td>Suburb</td>

	<td>{$data.suburb}</td>

</tr>

<tr>

	<td>State</td>

	<td>{$data.state}</td>

</tr>

<tr>

	<td>Postcode</td>

	<td>{$data.postcode}</td>

</tr>

<tr>

	<td>Phone</td>

	<td>{$data.phone}</td>

</tr>

<tr>

	<td colspan="2" align="center"><h1>Shipping information</h1></td>

</tr>

<tr>

	<td>Shipping Address</td>

	<td>{$data.shipping_address}</td>

</tr>

<tr>

	<td>Shipping Address 2</td>

	<td>{$data.shipping_address2}</td>

</tr>

<tr>

	<td>Shipping Suburb</td>

	<td>{$data.shipping_suburb}</td>

</tr>

<tr>

	<td>Shipping State</td>

	<td>{$data.shipping_state}</td>

</tr>

<tr>

	<td>Shipping Postcode</td>

	<td>{$data.shipping_postcode}</td>

</tr>

<tr>

	<td>Shipping Phone</td>

	<td>{$data.shipping_phone}</td>

</tr>

<tr>

	<td>Shipping Type</td>

	<td>

	{if $data.shipping == 1}Australia Express Post Next day delivery Sydney $7{/if}

	{if $data.shipping == 2}Australia Express post Next day Delivery Australia Wide $10{/if}

	{if $data.shipping == 3}DHL Australia Wide $60{/if}

	{if $data.shipping == 4}DHL Overseas $80{/if}

	</td>

</tr>

<tr>

	<td>Comments</td>

	<td>{$data.comments}</td>

</tr>

</table>