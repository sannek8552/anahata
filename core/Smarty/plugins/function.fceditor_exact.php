<?php
function smarty_function_fceditor_exact($params, &$smarty)
{

    if (!isset($params['value'])) {
        $smarty->trigger_error("eval: missing 'value' parameter");
        return;
    }

    $editor_name = 'FCKeditor1';
    if(isset($params['editor_name']))
    {
      $editor_name = $params['editor_name'];
    }
    
    $title = '';
    if (isset($params['title']))
    {
      $title = $params['title'];
    }

    $to_print = '';
    $just_proced = false;

    if(!isset($GLOBALS['js_out']) || empty($GLOBALS['js_out']))
    {
      $to_print = '';
      if(isset($params['init']))
      {
        $to_print = '<script type="text/javascript" src="'. $smarty->get_config_vars('js_url') .'tiny_mce/tiny_mce.js" ></script>';
      }
      $GLOBALS['js_out'] = 1;
      $just_proced = true;
    }
    
    if (is_array($GLOBALS['fceditor.init']))
    {
      $GLOBALS['fceditor.init'][] = $editor_name . 'id';
    }
    else
    {
      $GLOBALS['fceditor.init'] = array($editor_name . 'id');
    }    

    $to_print .= '<textarea name="'.$editor_name.'" id="'.$editor_name.'id'.'" style="width:100%;" title="'.$title.'">'.$params['value'].'</textarea>';
    return $to_print;
}
?>