{config_load file=templates.ini section="common"}
<script type="text/javascript">
    {literal}
    function display_select_type()
    {
        if(document.getElementById('subscribe_check_id').checked)
        {
            document.getElementById('subscribe_type_id').style.display = '';
        }
        else
        {
            document.getElementById('subscribe_type_id').style.display = 'none';
        }
    }
    {/literal}
</script>
<tr>
    <td>Username {req}</td>
    <td><input tabindex="1" type="text" name="login" value="{$reg_data.login}" title="string___Please input username" onblur="check_username(this.form.name,'login');"/>
        {if $reg_errors.login}<small class="required_class">{$reg_errors.login}</small>{/if}
    </td>
</tr>
<tr>
    <td>Email {req}</td>
    <td><input tabindex="2" type="text" name="email" value="{$reg_data.email}" title="email___Please input valid email" />
        {if $reg_errors.email}<small class="required_class">{$reg_errors.email}</small>{/if}
    </td>
</tr>
<tr>
    <td>Password {req}</td>
    <td><input tabindex="3" type="password" name="password" title="password_register___Please enter password same as retype password"/>
        {if $reg_errors.password}<small class="required_class">{$reg_errors.password}</small>{/if}
    </td>
</tr>
<tr>
    <td>Retype Password {req}</td>
    <td><input tabindex="4" type="password" name="retype_password"/>
        {if $reg_errors.retype_password}<small class="required_class">{$reg_errors.retype_password}</small>{/if}
    </td>
</tr>
<tr>
    <td>How did you hear about us?</td>
    <td>
        <select name="howhear" tabindex="5" >
            <option value="">Please select</option>
            {foreach from = $hear_categories item = item}
                <option value="{$item.id}" {if $reg_data.howhear == $item.id}selected{/if}>{$item.title}</option>
            {/foreach}
        </select>
    </td>
</tr>
<tr>
    <td>Subscribe to our newsletter</td>
    <td>
        <input type="checkbox" name="subscribe" {if $reg_data.subscribe > 0}checked{/if} value="1" id="subscribe_check_id" onclick="display_select_type()" /> <select name="subscribe_mail_type" {if !$reg_data.subscribe }style="display:none;"{/if} id="subscribe_type_id">            <option value="2" {if $reg_data.subscribe == 2} selected {/if}>HTML</option>            <option value="1" {if $reg_data.subscribe == 1} selected {/if}>Plain text</option>        </select>
    </td>
</tr>