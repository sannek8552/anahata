{config_load file=templates.ini section="common" scope="global"}
{$head|escape}<br/>
{foreach from = $csv item = item}
{$item|escape}<br/>
{/foreach}