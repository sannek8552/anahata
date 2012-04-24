{config_load file=templates.ini section="common"}

<form method="post" action="{#script_url#}{seo_url rm="Payment"}">
	<input type="hidden" name="pay" value="1">
	<input type="hidden" name="id" value="{$id}">
	<div>	
		<h3>Payment method:</h3>
		<p>
			<input type="radio" name="method" value="onsite" id="onsite_id" checked/>
			<label for="onsite_id"><b>Credit Card</b> Visa, Mastercard, Discover, American Express</label>
		</p>
		<p>
			<input type="radio" name="method" value="paypal" id="paypal_id">
			<a onclick="javascript:window.open('https://www.paypal.com/cgi-bin/webscr?cmd=xpt/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','width=400, height=350, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no');" href="javascript:void(0);"><img border="0" alt="Acceptance Mark" src="https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif"/></a>
			<label for="paypal_id">Save time. Pay securely using your stored payment information. Pay with credit card, bank account, or your PayPal account balance </label>
		</p>
		<h2>Total: {$total|money}</h2>
	
		<p>
			<input type="submit" name="continue" value="Continue"/>
		</p>
	</div>				
</form>