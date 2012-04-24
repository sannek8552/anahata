<?php
function smarty_function_fceditor($params, &$smarty)
{

    if (!isset($params['value'])) {
        $smarty->trigger_error("eval: missing 'value' parameter");
        return;
    }

    //if($params['value'] == '') {
    //    return;
    //}
	
   // $config = parse_ini_file('conf/templates.ini',1);
   // $base_path = $config['common']['base_path'];
  // require_once('FCKeditor/fckeditor.php');
   $editor_name = 'FCKeditor1';
   if(isset($params['editor_name']))
   	$editor_name = $params['editor_name'];
   	
   	
   	if (isset($params['height']))
   		$height = $params['height'];
   //$oFCKeditor = new FCKeditor($editor_name);
   //if(isset($params['height']))
   	//$oFCKeditor->Height = $params['height'];
  // $oFCKeditor->BasePath	= $base_path;
   //$oFCKeditor->Value = $params['value'];
   //print '<pre>';
   //print_r($smarty);return'';
   //return $oFCKeditor->Create();
    $to_print = '';
    $just_proced = false;
    //print_r($smarty->get_config_vars());return '';//['js_url'];
    if(!isset($GLOBALS['js_out']) || empty($GLOBALS['js_out']))
    {
    	$to_print = '';//'<script type="text/javascript" src="'. $smarty->get_config_vars('js_url') .'tiny_mce/tiny_mce.js" ></script>';    	
    	if(isset($params['init']))
    	{
    		$to_print = '<script type="text/javascript" src="'. $smarty->get_config_vars('js_url') .'tiny_mce/tiny_mce.js" ></script>';    	
    	}
    	$GLOBALS['js_out'] = 1;
	$just_proced = true;
    }
    $text_to_init=''.
    'mode : "textareas",  '.
    'theme : "advanced",'.  
    'plugins : "ibrowser,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu",  '.
    'theme_advanced_buttons1_add_before : "save,separator",  '.
    'theme_advanced_buttons1_add : "fontselect,fontsizeselect",'.  
    'theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",  '.
    'theme_advanced_buttons2_add_before: "cut,ibrowser,copy,paste,separator,search,replace,separator",  '.
    'theme_advanced_buttons3_add_before : "tablecontrols,separator",  '.
    'theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print",'.
    'theme_advanced_toolbar_location : "top",  '.
    'theme_advanced_toolbar_align : "left",  '.
    'theme_advanced_path_location : "bottom",  '.
    'plugin_insertdate_dateFormat : "%Y-%m-%d",  '.
    'plugin_insertdate_timeFormat : "%H:%M:%S",  '.
    'extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"';
    if($GLOBALS['js_out'] && !$just_proced)
	$text_to_init = '';
	
	if (!isset($height))
	$to_print .= '<textarea name="'.$editor_name.'" id="'.$editor_name.'id'.'" style="width:100%;">'.$params['value'].'</textarea>';
	else $to_print .= '<textarea name="'.$editor_name.'" id="'.$editor_name.'id'.'" style="width:100%;height:'.$height.'px;">'.$params['value'].'</textarea>';
	
    if(isset($params['init']))
	{
		if($text_to_init)
			$text_to_init .= ' ,';
		$to_print .= '<script language="javascript" type="text/javascript">tinyMCE.init({'.$text_to_init.'elements:"' .$editor_name  . '"});</script>';
	}
    //$to_print .= '<script language="javascript" type="text/javascript">tinyMCE.init({'.$text_to_init.',elements:"' .$editor_name  . '"});</script>';
    //$GLOBALS['text_to_init'][] = '{'.$text_to_init.',elements:"' .$editor_name  . '"}';
    return $to_print;
}
?>