<p>{config_load file=templates.ini section="common" scope="global"} </p>
{if $create_account}
<script type="text/javascript" src="{#js_url#}registration.js" ></script>
{/if}
<div id="contentBody">
<h1>Payment and Shipping</h1>
<p>Please complete the information below so we can send out your order.</p>
<fieldset name="information" id="information">
<legend>Shipping and Billing Details</legend>
<div id="checkoutTable">
<form name="payment" action="{#script_url#}{seo_url rm="Checkout"}" method="post" id="c_form" onsubmit="return process_save();">
<input type="hidden" name="js_save" value="1" />
{if $create_account}
      <table>
      	{include file='Common/registration_fields.tpl'}
      </table>
{/if}
<table>
<tr>
	<td colspan="2" valign="top"><strong>Billing Address</strong></td>
	<td colspan="2" align="left" valign="top"><strong>Shipping Address</strong>
	  <br />
	  	  <input type="checkbox" name="same" value="" class="auto" onclick="same_as_above(this);" />
	  Same as billing address</td>
</tr>
{*shipping address*}
<tr>
  <td width="130">Name</td>
  <td width="300"><input type="text" name="client_name" value="{$data.client_name}" tabindex="7" title="string___input your name"/>
    {if $error.client_name == 1}<small class="required_class">input your name</small>{/if}</td>
	<td>Street address</td>
    <td><input type="text" name="shipping_address" tabindex="50" value="{$data.shipping_address}" title="string___input&nbsp;address"/>
      {if $error.shipping_address == 1}<small class="required_class">input address</small>{/if}</td>
</tr>
<tr>
  <td>Street address</td>
  <td><input type="text" name="address" value="{$data.address}" tabindex="10" title="string___input address"/>
    {if $error.address == 1}<small class="required_class">input address</small>{/if}</td>
	<td nowrap="nowrap">Address line 2</td>
    <td><input type="text" name="shipping_address2" tabindex="55" value="{$data.shipping_address2}" />
      {if $error.shipping_address2 == 1}<small class="required_class">input address</small>{/if}</td>
</tr>
<tr>
  <td nowrap="nowrap">Address line 2</td>
  <td><input type="text" name="address2" value="{$data.address2}" tabindex="15" />
    {if $error.address2 == 1}<small class="required_class">input address</small>{/if}</td>
	<td>Suburb</td>
    <td><input type="text" name="shipping_suburb" value="{$data.shipping_suburb}" tabindex="60" title="string___input&nbsp;suburb"/>
      {if $error.shipping_suburb == 1}<small class="required_class">input suburb</small>{/if}</td>
</tr>
<tr>
  <td>Suburb</td>
  <td><input type="text" name="suburb" value="{$data.suburb}" tabindex="20" title="string___input suburb"/>
    {if $error.suburb == 1}<small class="required_class">input suburb</small>{/if}</td>
	<td>State</td>
    <td><input type="text" name="shipping_state" value="{$data.shipping_state}" tabindex="65" title="string___input&nbsp;state"/>
      {if $error.shipping_state == 1}<small class="required_class">input state</small>{/if}</td>
</tr>
<tr>
  <td>State</td>
  <td><input type="text" name="state" value="{$data.state}" tabindex="25" title="string___input state"/>
    {if $error.state == 1}<small class="required_class">input state</small>{/if}</td>
	<td>Postcode</td>
    <td><input type="text" name="shipping_postcode" value="{$data.shipping_postcode}" tabindex="70" title="string___input&nbsp;postcode"/>

      {if $error.shipping_postcode == 1}<small class="required_class">input postcode</small>{/if}</td>
</tr>
<tr>
  <td>Postcode</td>
  <td><input type="text" name="postcode" value="{$data.postcode}" tabindex="30" title="string___input postcode"/>
    {if $error.postcode == 1}<small class="required_class">input postcode</small>{/if}</td>
	<td>Phone</td>
    <td><input type="text" name="shipping_phone" value="{$data.shipping_phone}" tabindex="75" title="string___input&nbsp;phone"/>
      {if $error.shipping_phone == 1}<small class="required_class">input phone</small>{/if}</td>
</tr>
{*end of shipping*}

<tr>

  <td>Phone</td>

  <td><input type="text" name="phone" value="{$data.phone}" tabindex="35" title="string___input phone"/>

    {if $error.phone == 1}<small class="required_class">input phone</small>{/if}</td>

  <td>Country</td>
  <td>
        <select name="shipping_country" style="width:121px;" tabindex="76" title="string___select country">
                <option value="">Select Country</option>
                {foreach from=$countries item=c}
                <option value="{$c.country_id}" {if $c.country_id == $data.shipping_country_id}selected{/if}>{$c.name}</option>
                {/foreach}
        </select>
        {if $error.shipping_country == 1}<small class="required_class">input country</small>{/if}
  </td>
</tr>
<tr>
  <td>Country</td>
  <td>
        <select name="country" style="width:121px;" tabindex="36" title="string___select country">
                <option value="">Select Country</option>
                {foreach from=$countries item=c}
                <option value="{$c.country_id}" {if $c.country_id == $data.country_id}selected{/if}>{$c.name}</option>
                {/foreach}
        </select>
        {if $error.country == 1}<small class="required_class">input country</small>{/if}
  </td>


{if !$logged_user_data && !$create_account}

<tr>

  <td>Email</td>

  <td><input type="text" name="billing_email" value="{$data.email}" tabindex="40" title="email___input email" />

    {if $error.email == 1}<small class="required_class">input email</small>{/if}</td>

  <td>&nbsp;</td>

  <td>&nbsp;</td>
</tr>

{/if}

<tr>
	<td>Comments</td>
	<td><textarea name="comments" tabindex="45" cols="30" rows="8">{$data.comments}</textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
{*shipping address*}



 {*end of shipping*}
 </table>
</fieldset>
   
<fieldset name="information" id="information">
<legend>Shipping and Payment Details</legend>
   <table>
   {if $payment_error}
   <tr>
   		<td colspan="100" ><span class="required_class">{$payment_error}</span></td>
   </tr>
   {/if}
 <tr>


	<td width="130">Shipping type</td>

	<td>
		{$shipping.method} {if $shipping.price}{$shipping.price|money}{else}free{/if}
		{*
			{$ship_type.method}  {if $ship_type.price}{$ship_type.price|money}{else}free{/if}
			{if $error.shipping == 1}<small class="required_class">select shipping type</small>{/if}	
		*}
	</td>
	<td> </td>
    <td>&nbsp;</td>

    <td>&nbsp;</td>
</tr>
<tr id="ptype">
	<td>Payment method</td>

	<td valign="top"><select name="method" id="mid" tabindex="80" class="pad" onchange="change_method();">
	  
	    
	    
	    
	    {if $settings.deposit == 1}
	    
	  <option value="deposit" {if $data.method == 'deposit'}selected{/if}>Direct deposit</option>
	  
	    {/if}

		{if $settings.credit_card == 1}
		
	  <option value="card" {if $data.method == 'card'}selected{/if}>Credit card</option>
	  
		{/if}
		
		{if $settings.paypal == 1}
		
	  <option value="paypal" {if $data.method == 'paypal'}selected{/if}>Paypal</option>
	  
		{/if}
	    
	    
	  </select>	  
	  {if $error.method == 1}<small class="required_class">select payment method</small>{/if}</td>
	<td valign="bottom">&nbsp;</td>
	<td valign="bottom">&nbsp;</td>
	<td>&nbsp;</td>
</tr>

<tr id="card0">
{*
	<td>Credit Card Type</td>
	<td>
	<select name="card_type">
		<option value="Visa">Visa</option>
		<option value="Mastercard">MasterCard</option>
		<option value="Discover">Discover</option>
		<option value="Amex">Amex</option>
	</select>	
	</td>
*}
    <td>&nbsp;</td>
    <td>&nbsp;</td>

    <td>&nbsp;</td>
</tr> 
<tr id="card1">
	<td>Cardholder's name</td>
	<td><input type="text" value="{$card.card_name}" name="card_name" tabindex="85" />{if $error.card_name == 1}<small class="required_class">input card name</small>{/if}</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr id="card2">
	<td>Credit card number</td>
	<td><input type="text" name="card_number" tabindex="87" value="{$card.card_number}"/>{if $error.card_number == 1}<small class="required_class">input card number</small>{/if}</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr id="card3">
<td>Expire date</td>
	<td>
		<select name="expire_month" tabindex="90">
			<option value="01" {if $card.expire_month == '01'}selected{/if}>January</option>
			<option value="02" {if $card.expire_month == '02'}selected{/if}>February</option>
			<option value="03" {if $card.expire_month == '03'}selected{/if}>March</option>
			<option value="04" {if $card.expire_month == '04'}selected{/if}>April</option>
			<option value="05" {if $card.expire_month == '05'}selected{/if}>May</option>
			<option value="06" {if $card.expire_month == '06'}selected{/if}>June</option>
			<option value="07" {if $card.expire_month == '07'}selected{/if}>July</option>
			<option value="08" {if $card.expire_month == '08'}selected{/if}>August</option>
			<option value="09" {if $card.expire_month == '09'}selected{/if}>September</option>
			<option value="10" {if $card.expire_month == '10'}selected{/if}>October</option>
			<option value="11" {if $card.expire_month == '11'}selected{/if}>November</option>
			<option value="12" {if $card.expire_month == '12'}selected{/if}>December</option>
		</select>
		<select name="expire_year" tabindex="91">			
			<option value="10" {if $card.expire_year == '10'}selected{/if}>2010</option>
			<option value="11" {if $card.expire_year == '11'}selected{/if}>2011</option>
			<option value="12" {if $card.expire_year == '12'}selected{/if}>2012</option>
			<option value="13" {if $card.expire_year == '13'}selected{/if}>2013</option>
			<option value="14" {if $card.expire_year == '14'}selected{/if}>2014</option>
			<option value="15" {if $card.expire_year == '15'}selected{/if}>2015</option>
			<option value="16" {if $card.expire_year == '16'}selected{/if}>2016</option>
			<option value="17" {if $card.expire_year == '17'}selected{/if}>2017</option>
			<option value="18" {if $card.expire_year == '18'}selected{/if}>2018</option>
			<option value="19" {if $card.expire_year == '19'}selected{/if}>2019</option>
		</select>
		{if $error.expire_month == 1}<small class="required_class">select expire month</small>{/if}
		{if $error.expire_year == 1}<small class="required_class">select expire year</small>{/if}	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr id="card4">
	<td>CVV number</td>
	<td><input type="text" name="cvv_number" tabindex="95" value="{$card.cvv_number}"/>{if $error.cvv_number == 1}<small class="required_class">input cvv number</small>{/if}</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr id="deposit1">
	<td colspan="5">{$deposit}</td>
</tr>

{if $logged_user_data.discount_point > $settings.discount_limit}
<tr>
	<td valign="top">Use discount points:<br />(current discount: {$logged_user_data.discount_point|money})</td>
	<td><input type="checkbox" name="use_discount_point" onclick="calculate_discount_point();" id="discount_point_id" {if $use_discount_point}checked{/if} /></td>
</tr>
{/if}

<tr>
	<td valign="bottom"><b>Total price:</b></td>
	<td valign="bottom"><b id="total_box">
	{if $total_with_coupons === 0 || $total_with_coupons > 0}
	    <strike>{$cart_total|money}</strike>
	    {if $total_with_coupons === 0}
	    	free
	    {else}
	    	{$total_with_coupons|money}
	    {/if}
	{else}
	    {$cart_total|money}
	{/if}
	</b></td>
    <td valign="bottom">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td colspan="5" align="left">
		<input id="saveid" type="submit" name="save" value="Process" class="button" />	</td>
</tr>
</table>
</form>
</fieldset>
</div>
<script type="text/javascript">

var real_total = 0;
{if $real_total}
real_total = {$real_total}
{/if}
{if $logged_user_data.discount_point > $settings.discount_limit}
	var discount_point = {$logged_user_data.discount_point};
	var real_total_text = '{$real_total|money}';
	var discount_point_text = '{$real_total-$logged_user_data.discount_point|money}';
	var to_undisplay = ['ptype', 'card0', 'card'];
{/if}
{if $total}
	var total = {$total};
{else}
	var total = 0;
{/if}
var start_method = 'deposit';

{if $data.method == 'card'}	
	start_method = 'card';
{/if}
{literal}

window.addEvent('domready',function(){change_method();calculate_discount_point();});

function calculate_discount_point()
{
	if (document.getElementById('discount_point_id') != undefined)
	{
		var elem = document.getElementById('discount_point_id');
		not_pay = false;
		if (elem.checked)
		{
			
			if (discount_point < real_total)
			{
				document.getElementById('total_box').innerHTML = discount_point_text;
			}
			else
			{
				document.getElementById('total_box').innerHTML = '$0';
				process_card('none');
				process_deposit('none');
				document.getElementById('ptype').style.display = 'none';
				not_pay = true;
			}
		}
		else 
		{
			document.getElementById('total_box').innerHTML = real_total_text;
			document.getElementById('ptype').style.display = '';
			change_method();
		}
		
	}	
}

function process_save()
{
	if (to_check['payment'] == undefined) validator.add('payment');
	change_method();
	if (validator.check('payment'))
	{
		var save = document.getElementById('saveid');
		save.disabled = true;		
		document.forms['save'] = 'Save';
		var elem = document.getElementById('mid');
		if (elem.value == 'card')
		{
			document.forms['payment'].action = {/literal}'{#https_url#}{seo_url rm="Checkout"}'{literal};
		}
		return true;
	}
	document.forms['payment'].onsubmit = function(){return process_save();};
	return false;
}



function change_method()
{	
	//alert(start_method);
	var method;
	if (start_method == 'card')
	{
		$('mid').value = 'card';
		start_method = '';
	}
	method = $('mid').value;
	if (method == 'deposit' || method == 'paypal')
	{
		process_card('none');
		process_deposit('');
	}

	if (method == 'card')
	{
		process_deposit('none');
		process_card('');
	}
}

function process_card(type)
{
	$('card0').style.display = type;	
	$('card1').style.display = type;
	$('card2').style.display = type;
	$('card3').style.display = type;
	$('card4').style.display = type;	

	if (to_check['payment'] != undefined)
	{
		if (type == '')			
		{			
			to_check['payment']['card_name'] = {limit:'string',message:'input card name'};			
			to_check['payment']['card_number'] = {limit:'string',message:'input card number'};			
			to_check['payment']['cvv_number'] = {limit:'string',message:'input cvv number'};			
		}			
		else			
		{			
			to_check['payment']['card_name'] = {};			
			to_check['payment']['card_number'] = {};			
			to_check['payment']['cvv_number'] = {};			
		}
	}
}

function process_deposit(type)
{
	$('deposit1').style.display = type;
}

function change_shipping()
{
	var new_total = new Number(0);
	$('tid').innerHTML = "$ "+new_total.toFixed(2);
}
function same_as_above(obj)
{
	if(obj.checked)
	{
		$('c_form').elements['shipping_address'].value = $('c_form').elements['address'].value;
		$('c_form').elements['shipping_address2'].value = $('c_form').elements['address2'].value;
		$('c_form').elements['shipping_suburb'].value = $('c_form').elements['suburb'].value;
		$('c_form').elements['shipping_state'].value = $('c_form').elements['state'].value;
		$('c_form').elements['shipping_postcode'].value = $('c_form').elements['postcode'].value;
		$('c_form').elements['shipping_phone'].value = $('c_form').elements['phone'].value;
		$('c_form').elements['shipping_country'].value = $('c_form').elements['country'].value;
	}
	else
	{
		$('c_form').elements['shipping_address'].value = '';
		$('c_form').elements['shipping_address2'].value = '';
		$('c_form').elements['shipping_suburb'].value = '';
		$('c_form').elements['shipping_state'].value = '';
		$('c_form').elements['shipping_postcode'].value = '';
		$('c_form').elements['shipping_phone'].value = '';
        $('c_form').elements['shipping_country'].value = '';

	}
}
{/literal}
</script>