{config_load file=templates.ini section="common"}

<script type="text/javascript">
    {literal}
    $(document).ready(function(){

        $('input[type=submit]').button();
    });
    {/literal}

</script>
<h1>Авторизация</h1>
<form method="post" action="{if $request_uri}{else}{#script_url#}{seo_url rm="CommonLogin"}{/if}">
<table>
{if $login_failed}
<tr>
	<td class="required_class"></td>
</tr>
{/if}
<tr>
	<td>Логин</td>
	<td><input type="text" name="login" /></td>
</tr>
<tr>
	<td>Пароль</td>
	<td><input type="password" name="password"/></td>
</tr>
<tr>
	<td><input type="hidden" name="request_uri" value="{$request_uri}" /></td>
	<td><input type="submit" name="sign_in" value="Войти"/></td>
</tr>
</table>
</form>