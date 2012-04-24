<div id="bodyContent">
<h1>Remind Password</h1>
{if $confirmed}
  Your password was succesfully changed. You can <a href="{#script_url#}{seo_url rm="Login"}">login</a> now!
{elseif $mail_sended}
  An e-mail with your new password has been sent to the e-mail address you have entered, please check for further instructions.
{else}
{if $not_finded}There are no users with such login/email<br />{/if}
<form name="remind_password_form" method="post" action="{#script_url#}{seo_url rm="Remind_Password"}">
<div>        
    <div class="notes">
        Please enter your e-mail and press the 'remind' button below.<br /><br />
    </div>
    <table>
    <tr>
        <td>
            <label for="email">Email:</label>
            <input type="text" name="email" />
        </td>
    </tr>
    </table>
    <div class="submit">
        <input type="submit" name="remind_password" value="Remind" class="short" />
    </div>
</div>
</form>
{/if}
</div>