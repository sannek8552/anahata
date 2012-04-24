{config_load file=templates.ini section="common"}
<div id="contentBody">
{if $registered == 1}
	<div>Thank you for registering</div>

{else}
<script type="text/javascript" src="{#js_url#}registration.js" ></script>
<form name="register" action="{#script_url#}{seo_url rm="Registration"}" method="post" >
{if $referral_id}
	<input type="hidden" name="referral_id" value="{$referral_id}" />
{/if}
<h3>Registration</h3>
	<table>
		<tr>
			<td colspan="2"></td>
		</tr>
		{include file='Common/registration_fields.tpl'}
		<tr>
			<td></td>
			<td><input type="submit" name="save" value="Register" class="button" /></td>
		</tr>
	</table>
</form>
</div>
<script type="text/javascript" >
validator.add('register');
</script>
{/if}