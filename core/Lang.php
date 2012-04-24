<?php
	if (file_exists('conf/templates.ini'))
	{
    	$templates = parse_ini_file('conf/templates.ini',true);
	}
	else 
	{
		PEAR::raiseError("Missing templates config");
	}
	

    if (isset($templates['common']['default_lang']))
    {
        require_once('lang/'.$templates['common']['default_lang'].'.php');
        if (isset($_LANG) and is_array($_LANG))
        {
            foreach ($_LANG as $key => $value)
            {
                define($key,$value);
            }
        }
    }
?>