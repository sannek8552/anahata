{config_load file=templates.ini section="common" scope="global"}
{if !$user.text_type}
<img style="width: 1px;height: 1px;" src="{#domain_name#}{#script_url#}?rm=nl_set_read&id={$mail_id}&key={$read_key}"/>
{/if}

