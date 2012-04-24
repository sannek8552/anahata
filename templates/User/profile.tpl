{config_load file=templates.ini section="common"}
<script type="text/javascript" src="{#js_url#}profile.js"> </script>
<div id="bodyContent">
<h1>My Account</h1>
 <div class="hidden"> 
   <h1>Discount points</h1>
   Your discount: {if $data.discount_point}{$data.discount_point|money}{else}0{/if}
   <br />
   {if $data.discount_point < $settings.discount_limit}
   You can use your discount points after reaching {$settings.discount_limit|money}
   {else}
   You can use your discount points
   {/if}</div>
<br />
<br />
    <fieldset name="information" id="information">
      <legend>Your Profile</legend>
<form name="change_pass" action="{#script_url#}{seo_url rm="Profile"}" method="post">
<table>
{if $change_data_success == 1}
<tr>
	<td colspan="2">Your profile has been updated.</td>
</tr>
{/if}
<tr>
	<td width="150"><strong>Referral link</strong></td>
	<td>{#full_url#}{seo_url rm=Registration param1=$data.user_id}</td>
</tr>
<tr>
	<td width="150"><strong>Username</strong></td>
	<td>{$data.login}</td>
</tr>
<tr>
	<td><strong>E-mail:</strong></td>
	<td>
		<input type="text" name="email" value="{$data.email}" title="email___Please enter email" />
		{if $errors.email}<small class="required_class">{$errors.email}</small>{/if}
	</td>
</tr>
<tr>
	<td><strong>Password</strong></td>
	<td><input type="password" name="password" />
		{if $errors.password}<small class="required_class">{$reg_errors.password}</small>{/if}
		<br />
		Leave blank if you don't want to change password
	</td>
</tr>
<tr>
	<td><strong>Retype Password</strong></td>
	<td><input type="password" name="retype_password"/>
		{if $errors.retype_password}<small class="required_class">{$reg_errors.retype_password}</small>{/if}
	</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" name="change_password" value="Update profile" class="short" /></td>
</tr>
</table>
</form>
</fieldset>
<form name="profile" action="{#script_url#}{seo_url rm="Profile"}" method="post" >
<fieldset name="information" id="information">
      <legend>Contact Details</legend>
<table>
{include file='User/profile_billing_and_shipping_fields.tpl'}

<tr>
	<td></td>
	<td><input type="submit" name="save" value="Save" class="short" /></td>
</tr>
</table></fieldset>
</form>
</div>
<script type="text/javascript">
validator.add('profile');
validator.add('change_pass');
</script>