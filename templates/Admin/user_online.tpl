{config_load file=templates.ini section="common" scope="global"}
<div class="table-list">
    <h1>Online users</h1>
    <table>
        <thead>
            <tr>
                <th scope="col" nowrap="nowrap">Login</th>
                <th scope="col" nowrap="nowrap">Email</th>
            </tr>
        </thead>
        <tbody>
        {foreach from=$onlineusers item=item key=key}
        <tr>
            <td>
                {if $item.isadmin}
                <span>{$item.login}</span>
                {else}
                <a href="{#script_url#}{seo_url rm=UserList param1=edit param2=$key}" title="Edit user" style="padding-left: 0;">{$item.login}</a>
                {/if}
            </td>
            <td>
                {$item.email}
            </td>
        </tr>
        {/foreach}
        </tbody>
    </table>
</div>