{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript">
var sn = '{$sn}';
var cfg = {$json_cfg};
var restaurant_id = '{$restaurant_id}';
</script>
<script type="text/javascript" src="{#js_url#}Admin/Tree/structure.js"></script>
{*<div><a href="{#script_url#}{seo_url rm="Edit_Menu" param1=$restaurant_id}"><img src="{#img_url#}up.gif" alt="up" />UP</a></div>*}
<div id="droot_div">
</div>