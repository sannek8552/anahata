{config_load file=templates.ini section="common"}
<div id="bodyContent">
<fieldset name="information" id="information">
<legend>Checkout</legend>
<div style="float:left;margin-right:30px;">
	<form name="reg_in" action="{#script_url#}{seo_url rm="RegistrationInCheckout"}" method="post">
		<h2>Create a New Account</h2>	
    <table>

		<tr>
			<td>Want to create new account?</td>
			<td><input type="radio" name="reg_in_check" value="1" /></td>
		</tr>
		<tr>
			<td>Proceed as guest</td>
			<td><input type="radio" name="reg_in_check" value="2" /></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>		
			<td colspan="2" align="right"><input type="submit" name="next" value="Next &rarr;" class="short" /></td>
		</tr>
		{if $error}
		<tr>
			<td colspan="2"><span class="required_class">{$error}</span></td>
		</tr>
		{/if}
	</table>
	</form>
</div>
<div>
	<form method="post" action="{#https_url#}{seo_url rm="Checkout"}">
    <h2>Have account? </h2>
	<table>	
	<tr>
		<td colspan="2">		  <strong>Please log in</strong></td>
	</tr>
	{if $error_login == 1}
	<tr>
		<td colspan="2" class="required_class">Invalid login or password</td>
	</tr>
	{/if}
	<tr>
		<td>Login</td>
		<td><input type="text" name="login" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="sign_in" value="Login" class="short" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td><a href="{#script_url#}{seo_url rm="Remind_Password"}">Remind Password</a></td>
	</tr>
	</table>
	</form>
</div>
</fieldset>
</div>