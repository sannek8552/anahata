
{if $status_code=='invalid_login'}
<span class="e_message">Invalid login/password pair</span>
{elseif $status_code == 'login_unique_e'}
<span class="e_message">Login Not Available</span>
{elseif $status_code == 'email_unique_e'}
<span class="e_message">Email Not Available</span>
{elseif $status_code == 'password_mismatch_e'}
<span class="e_message">Password and password confirmation missmatch</span><br>
{elseif $status_code == 'agent_added'}
<span class="s_message">User added</span><br>
{elseif $status_code == 'agent_updated'}
<span class="s_message">User updated</span><br>
{elseif $status_code == 'agent_deleted'}
<span class="s_message">User removed</span><br>
{elseif $status_code == 'profile_updated'}
<span class="s_message">Profile updated</span><br>
{/if}