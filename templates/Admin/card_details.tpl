<p>{config_load file=templates.ini section="common" scope="global"} </p>

<table>
	<tr>
		<td colspan="2">Email with credit card details</td>
	</tr>
	<tr>
	  <td valign="top"><strong>Transaction ID</strong></td>
	  <td>{$data.transaction_id}</td>
  </tr>
  <tr>
  	<td>Card name </td>
  	<td>{$card.card_name}</td>
  </tr>
  <tr>
  	<td>Card number </td>
  	<td>{$card.left_numbers} ******** {$card.right_numbers}</td>
  </tr>
  <tr>
  	<td>Expire month</td>
  	<td>{$card.expire_month}</td>
  </tr>
  <tr>
  	<td>Expire year</td>
  	<td>{$card.expire_year}</td>
  </tr>
  <tr>
  	<td>CVV number</td>
  	<td>{$card.cvv_number}</td>
  </tr>
</table>  