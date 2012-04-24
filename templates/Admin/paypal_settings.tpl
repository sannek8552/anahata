<h2>PayPal Settings</h2>
<form method="post" action="{#script_url#}{seo_url rm="PaypalSettings"}">    
<fieldset name="information" id="information">
      <legend>Details</legend>
<table>
<tr>
	<td>API USERNAME</td><td><input size="100" type="text" name="API_USERNAME" value="{$paypal.API_USERNAME}"></td>
</tr>
<tr>
	<td>API PASSWORD</td><td><input size="100" type="text" name="API_PASSWORD" value="{$paypal.API_PASSWORD}"></td>
</tr>
<tr>
	<td>API SIGNATURE</td><td><input size="100" type="text" name="API_SIGNATURE" value="{$paypal.API_SIGNATURE}"></td>
</tr>
<tr>
	<td>API ENDPOINT</td><td><input size="100" type="text" name="API_ENDPOINT" value="{$paypal.API_ENDPOINT}"></td>
</tr>
<tr>
	<td>PAYPAL URL</td><td><input size="100" type="text" name="PAYPAL_URL" value="{$paypal.PAYPAL_URL}"></td>
</tr>
<tr>
	<td>VERSION</td><td><input size="100" type="text" name="VERSION" value="{$paypal.VERSION}"></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" name="save" value="Save" class="submit-button"></td>
</tr>
</table>
</form>
</fieldset>