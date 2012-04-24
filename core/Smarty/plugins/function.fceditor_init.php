<?php
function smarty_function_fceditor_init($params, &$smarty)
{
    $text_to_init=''.
    'mode : "exact",  '.
    'theme : "advanced",'.  
    'plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu,youtube,ibrowser",  '.
    'theme_advanced_buttons1_add_before : "save,separator",  '.
    'theme_advanced_buttons1_add : "fontselect,fontsizeselect",'.  
    'theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",  '.
    'theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",  '.
    'theme_advanced_buttons3_add_before : "tablecontrols,separator",  '.
    'theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,youtube,ibrowser",'.
    'theme_advanced_toolbar_location : "top",  '.
    'theme_advanced_toolbar_align : "left",  '.
    'theme_advanced_path_location : "bottom",  '.
    'plugin_insertdate_dateFormat : "%Y-%m-%d",  '.
    'plugin_insertdate_timeFormat : "%H:%M:%S",  '.
    'extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"';

    if (isset($GLOBALS['fceditor.init']) and is_array($GLOBALS['fceditor.init']))
    {
      $editor_name = join(",",$GLOBALS['fceditor.init']);    
      $to_print .= '<script language="javascript" type="text/javascript">tinyMCE.init({'.$text_to_init.',elements:"' .$editor_name  . '"});</script>';
      return $to_print;
    }
}
?>