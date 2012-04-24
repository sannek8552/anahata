<?php


class SettingsHolder
{
    var $table = 'settings_new';
	
    function SettingsHolder()
    {

    }
    function getSettings()
    {
        //return $GLOBALS['core.sql']->getRow("select * from #p#settings where id = ?",array(1));
        return $this->loadSettings();
    }

    function saveSettings($settings)
    {
        $cur_settings = $this->loadSettings();
        foreach ($settings as $key => $value)
        {
            if (isset($cur_settings[$key]))	$GLOBALS['core.store']->save($this->table,array('value' => $value),array('key_name' => 'name','key_value' => $key));
            else $GLOBALS['core.store']->save($this->table,array('name' => $key,'value' => $value),array('key_name' => 'id'));
        }
    }

    function loadSettings()
    {
        $res = $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." ",array(),'name');
        $to_ret = array();
        foreach ($res as $key => $value) $to_ret[$value['name']] = $value['value'];
        return $to_ret;
    }
}


?>