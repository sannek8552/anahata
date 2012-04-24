{config_load file=templates.ini section="common" scope="global"}
<p>{$entry.content}</p>
<strong>{$entry.name|escape}</strong>