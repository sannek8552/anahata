{config_load file=templates.ini section="common" scope="global"}
<form id="edit_form" action="javascript:void(0);" method="post">
<table>
    <tr>
            <td>Username:</td>
            <td>
                <input type="text" name="login" value="{$user_info.login}" style="width:auto"/>
                {if $err.login}<br />Unavailable username{/if}
            </td>
    </tr>
    <tr>
            <td>Groups:</td>
            <td>
               
                <select name="groups" multiple style="width:auto">
                    <option value="admin" {if $groups.admin}selected{/if}>Admin</option>
                    <option value="user" {if $groups.user}selected{/if}>User</option>
                </select>
                {if $err.groups}<br />Please, check groups{/if}
            </td>
    </tr>
    {*    
    <tr>
            <td>First Name:</td>
            <td><input type="text" name="first_name" value="{$user_info.first_name}" style="width:auto"/></td>
    </tr>
    <tr>
            <td>Last Name:</td>
            <td><input type="text" name="last_name" value="{$user_info.last_name}" style="width:auto"/></td>
    </tr>
    *}
    <tr>
            <td>E-Mail:</td>
            <td>
                <input type="text" name="email" value="{$user_info.email}" style="width:auto"/>
                {if $err.email}<br />Wrong E-mail{/if}
            </td>
    </tr>
    {*
    <tr>
            <td>Phone:</td>
            <td><input type="text" name="phone" value="{$user_info.phone}" style="width:auto"/></td>
    </tr>
    *}
    <tr>
        <td colspan="2">

            <input type="button" name="save" value="Save" style="width:auto" onclick="user.save_edit('edit_form');"/>
            <input type="hidden" name="user_id" value="{$user_info.user_id}" />
        </td>
    </tr>
</table>
</form>