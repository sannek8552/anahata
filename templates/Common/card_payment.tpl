{config_load file=templates.ini section="common"}
<div id="bodyContent">
<script type="text/javascript" src="{#js_url#}slimbox_module.js"></script>
<script type="text/javascript" src="{#js_url#}body_blocker.js"></script>
{if $message}
<div style="border:1px solid #ff7777;background:#ffcccc;text-align:center;">
	{$message}
</div>
{/if}
<form method="post" action="{#script_url#}">
<input type="hidden" name="rm" value="CardPayment"/>
<input type="hidden" name="id" value="{$id}"/>
<table>
<tr>
	<td colspan="2">
		<h3>Credit Card Information</h3>
	</td>
</tr>
<tr>
	<td>
	Credit Card Type:
	</td>
	<td>
	<select name="cc_type">
		<option value="Visa">Visa</option>
		<option value="Mastercard">MasterCard</option>
		<option value="Discover">Discover</option>
		<option value="Amex">Amex</option>
	</select>			
	</td>
</tr>
<tr>
	<td>
	Cardholder's First Name:
	</td>
	<td>
	<input type="text" name="cc_first_name" value="{$cc_first_name}"/>
	{if $errors.cc_first_name}<br/><small class="required_class">First name required</small>{/if}
	</td>
</tr>
<tr>
	<td>
	Cardholder's Last Name:
	</td>
	<td>
	<input type="text" name="cc_last_name" value="{$cc_last_name}"/>
	{if $errors.cc_last_name}<br/><small class="required_class">Last name required</small>{/if}
	</td>
</tr>
<tr>
	<td>
	Credit card number (no spaces or dashes):
	</td>
	<td>
	<input type="text" name="cc_number" value="{$cc_number}" maxlength="16"/>
	{if $errors.cc_number}<br/><small class="required_class">Credit card number required</small>{/if}
	</td>
</tr>
<tr>
	<td>
		Expiration date (month/year):
	</td>
	<td>
		<select name="cc_expiration_month">
			<option value="01" {if $cc_expiration_month == '01'}selected{/if}>01</option>
			<option value="02" {if $cc_expiration_month == '02'}selected{/if}>02</option>
			<option value="03" {if $cc_expiration_month == '03'}selected{/if}>03</option>
			<option value="04" {if $cc_expiration_month == '04'}selected{/if}>04</option>
			<option value="05" {if $cc_expiration_month == '05'}selected{/if}>05</option>
			<option value="06" {if $cc_expiration_month == '06'}selected{/if}>06</option>
			<option value="07" {if $cc_expiration_month == '07'}selected{/if}>07</option>
			<option value="08" {if $cc_expiration_month == '08'}selected{/if}>08</option>
			<option value="09" {if $cc_expiration_month == '09'}selected{/if}>09</option>
			<option value="10" {if $cc_expiration_month == '10'}selected{/if}>10</option>
			<option value="11" {if $cc_expiration_month == '11'}selected{/if}>11</option>
			<option value="12" {if $cc_expiration_month == '12'}selected{/if}>12</option>
		</select>
		<select name="cc_expiration_year">
			<option value="2008" {if $cc_expiration_year == '2008'}selected{/if}>2008</option>
			<option value="2009" {if $cc_expiration_year == '2009'}selected{/if}>2009</option>
			<option value="2010" {if $cc_expiration_year == '2010'}selected{/if}>2010</option>
			<option value="2011" {if $cc_expiration_year == '2011'}selected{/if}>2011</option>
			<option value="2012" {if $cc_expiration_year == '2012'}selected{/if}>2012</option>
			<option value="2013" {if $cc_expiration_year == '2013'}selected{/if}>2013</option>
			<option value="2014" {if $cc_expiration_year == '2014'}selected{/if}>2014</option>
			<option value="2015" {if $cc_expiration_year == '2015'}selected{/if}>2015</option>
			<option value="2016" {if $cc_expiration_year == '2016'}selected{/if}>2016</option>
			<option value="2017" {if $cc_expiration_year == '2017'}selected{/if}>2017</option>
			<option value="2018" {if $cc_expiration_year == '2018'}selected{/if}>2018</option>
		</select>
	</td>
</tr>
<tr>
	<td>Credit Card CVV Value:</td>
	<td>
		<input type="text" name="cc_cvv" value="{$cc_cvv}" size="2" maxlength="4"/>
		{*
		<a href="#" onclick="Lightbox.get_html('ajax_cvv_help');"><img src="{#img_url#}help.gif" border="0" alt="Help" width="16" height="16"/></a>
		*}
		{if $errors.cc_cvv}<br/><small class="required_class">Credit Card CVV value required</small>{/if}
		
	</td>
</tr>
<tr>
	<td colspan="2">
		<h3>Billing Address</h3>
	</td>
</tr>
<tr>
	<td>Country:</td>
	<td>
		<select name="cc_billing_country" onchange="submit();" style="width:220px;">
			<option value="">Select Country</option>
			{foreach from=$countries item=c}
			<option value="{$c.id}" {if $c.id == $cc_billing_country}selected{/if}>{$c.name}</option>
			{/foreach}
		</select>
		{if $errors.cc_billing_country}<br/><small class="required_class">Country required</small>{/if}
	</td>
</tr>
{if $states}
<tr>
	<td>State:</td>
	<td>				
		<select name="cc_billing_state">
			<option value="">Select state</option>
			{foreach from=$states item=c}
			<option value="{$c.code}" {if $c.code==$cc_billing_state}selected{/if}>{$c.state}</option>
			{/foreach}
		</select>
		{if $errors.cc_billing_state}<br/><small class="">State required</small>{/if}
	</td>
</tr>
{/if}
<tr>
	<td>City:</td>
	<td>
		<input type="text" name="cc_billing_city" value="{$cc_billing_city}"/>
		{if $errors.cc_billing_city}<br/><small class="required_class">City required</small>{/if}
	</td>
</tr>
<tr>
	<td>ZIP/Postal Code:</td>
	<td>
		<input type="text" name="cc_billing_zip" value="{$cc_billing_zip}"/>
		{if $errors.cc_billing_zip}<br/><small class="required_class">Zip code required</small>{/if}
	</td>
</tr>
<tr>
	<td>Address:</td>
	<td>
		<input type="text" name="cc_billing_address" value="{$cc_billing_address}"/>
		{if $errors.cc_billing_address}<br/><small class="required_class">Card Holder Billing Address required</small>{/if}
	</td>
</tr>
<tr>
	<td>Total</td>
	<td>{$total|money}</td>
</tr>
</table>		
<p>
	<input type="submit" name="checkout" id="button" value="Check Out"/>
</p>
</form>
</div>