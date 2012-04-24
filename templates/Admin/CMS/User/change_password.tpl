{config_load file=templates.ini section="common" scope="global"}
<form id="password_form" action="javascript:void(0);" method="post">
<table>
    <tr>
            <td>Username:</td>
            <td>
               {$user_info.login}
                
            </td>
    </tr>
     <tr>
            <td>Password:</td>
            <td>
                <input type="password" name="user_password" value="" style="width:auto"/>
                {if $err.user_password}<br />Please, enter user password{/if}
            </td>
    </tr>
    <tr>
            <td>Retype password:</td>
            <td>
                <input type="password" name="user_password_retype" value="" style="width:auto"/>
                {if $err.user_password_retype}<br />RetypePassword error{/if}
            </td>
    </tr>
    <tr>
        <td colspan="2">

            <input type="button" name="save" value="Save" style="width:auto" onclick="user.save_password('password_form');"/>
            <input type="hidden" name="user_id" value="{$user_info.user_id}" />
        </td>
    </tr>
</table>
</form>




