<?php
class Config_User {
    var $groups;
    var $uid;
    var $data;
    function init($uid = '', $user_info = array())
    {
		if(!empty($uid))
		{
		    $this->uid = $uid;
		    $user_info = $GLOBALS['core.sql']->getRow("SELECT * FROM #p#user WHERE user_id=?",$this->uid);
		    if(!PEAR::isError($user_info) && !empty($user_info))
		    {
				$groups = explode(',',$user_info['groups']);
				foreach($groups as $key => $value)
				{
				    $this->groups[$value] = 1;
				}
				$this->data = $user_info;   
		    }
		}
		elseif (!empty($user_info))
		{
			$this->uid = $user_info['user_id'];
			$groups = explode(',',$user_info['groups']);
			foreach($groups as $key => $value)
			{
			    $this->groups[$value] = 1;
			}
			$this->data = $user_info;    
		}
		else
		{    
		    $this->uid = '';
		}
		unset($this->data['groups']);
    }
    function Config_User()
    {
		$this->groups = array();
		$this->data = array();
		$this->groups['anonymous'] = 1;	
    }
    function is_member_of($group)
    {
		return isset($this->groups[$group]) ? true : false;
    }
    function get_data()
    {
		return $this->data;
    }
    function set_data($data)
    {
		if(!is_array($data))
		{
		    //raise error
		}
		$this->data = $data;
    }
    /*no one use it
    function save()
    {
		$save_data = $this->data;
		unset($save_data['user_id']);
		unset($save_data['created']);
		unset($save_data['updated']);
		$save_groups = $this->groups;
		unset($save_groups['anonymous']);
		$save_data['groups'] = join(',',array_keys($save_groups));
		$key_data = array('key_name' => 'user_id');
		if(!empty($this->uid))
		{
		    $key_data['key_value'] = $this->uid;
		}
		$result =  $this->store->save('user',$save_data,$key_data);
		if(PEAR::isError($result))
		    return $result;
		if(empty($this->uid))
		{
		    $this->uid = $this->store->last_id();
		    //$this->data['user_id'] = $this->uid;
		    $this->init($this->uid);
		}
	
    }*/
    function create_password($password)
    {
		return md5($password);
    }
    function set_value($name, $value)
    {
		$this->data[$name] = $value;
    }
}
?>