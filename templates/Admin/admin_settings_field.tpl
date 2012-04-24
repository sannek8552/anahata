{config_load file=templates.ini section="common" scope="global"}

{if $field.type == 'bool'}
<input type="checkbox" name="{$field.name}" {if $field.value == 1}checked{/if} />
{elseif $field.type == 'int'}
<input type="text" name="{$field.name}" value="{$field.value}" />
{elseif $field.type == 'string'}
<input type="text" name="{$field.name}" value="{$field.value}" {if $field.email}class="email_input"{/if} />
{elseif $field.type == 'radio'}
<input type="radio" name="{$field.name}" value="{$field.value}" {if $field.value == $field.db_value}checked{/if} />
{/if}
{$field.name}