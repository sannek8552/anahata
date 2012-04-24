<?php
require_once('Data_Holder.php');

class User_Holder extends Data_Holder_Simple
{
	function User_Holder($id = null)
	{
		$table = 'user';
		$key_info = array('key_name' => 'user_id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}

	function getAll()
	{
		return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#" . $this->table. " ORDER BY id ASC",array(), 'user_id');
	}

        function isLoginExist($login)
	{
		return $GLOBALS['core.sql']->getOne("SELECT login FROM #p#" . $this->table. " WHERE login = ?",$login);
	}
	
	
       
}
?>