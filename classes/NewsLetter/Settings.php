<?php

class NLSettings{
	static $settings = array();
	
	function value($name){
		if(!isset(NLSettings::$settings[$name]))
			NLSettings::$settings[$name] = $GLOBALS['core.sql']->getOne(
				"SELECT value FROM #p#nl_settings WHERE name=? ",
				array($name));

		return NLSettings::$settings[$name];
	}
	
	function get_all(){
		return  $GLOBALS['core.sql']->getAll(
			"SELECT * FROM #p#nl_settings ORDER BY pos ASC ",
			array());
	}
	function save_all($data){
		foreach ($data as $i=>$v)
			 $GLOBALS['core.sql']->query(
				"UPDATE #p#nl_settings SET value=? WHERE name=? ",
				array($v, $i)
				);
	}
}
?>