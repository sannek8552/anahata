{config_load file=templates.ini section="common" scope="global"}

{if $field.type == 'bool'}
<input type="checkbox" name="{$field.name}" {if $field.value == 1}checked{/if} class="auto" />
{elseif $field.type == 'int'}
<input type="text" name="{$field.name}" value="{$field.value}" />
{elseif $field.type == 'string'}
<input type="text" name="{$field.name}" value="{$field.value}" />
{elseif $field.type == 'password'}
<input type="password" name="{$field.name}" value="{$field.value}" />
{/if}