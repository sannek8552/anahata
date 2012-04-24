{config_load file=templates.ini section="common" scope="global"}
{if $swf}
<div id="{$banner_id}"></div>
<script type="text/javascript">swfobject.embedSWF("{#script_url#}upload/banner/{$data.img}", "{$banner_id}", "{$data.width}", "{$data.height}", "9.0.0", "{#js_url#}swf/expressInstall.swf");</script>
{else}
<a class='banner' href='{$data.link}' target='_blank' title='{$data.alt}'><img src='{#script_url#}upload/banner/{$data.img}' width='{$data.width}' height='{$data.height}' alt='{$data.alt}' /></a>
{/if}