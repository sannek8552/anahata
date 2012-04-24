{config_load file=templates.ini section="common" scope="global"}
{literal}

{/literal}
<form id="mail_form" name="mail_form" action="javascript:void(0);" method="post">
    <table style="text-align:left;width:100%;">
        <tr>
            <td>E-mail</td>
            <td>
                <input type="text" name="email" id="email_id" value="{$data.email}"/>
                {if $errors.email}<br /><span class="required_class">Please, enter valid email</span>{/if}
            </td>
        </tr>
        <tr>
            <td><input type="hidden" name="posting_id" value="{$id}" /></td>
            <td><input type="button" style="width: auto;" name="send" value="Send" onclick="nlposting.send_test_mail('mail_form');" /></td>
        </tr>
    </table>
</form>

