<?php
require_once('Listable.php');
require_once('modules/ActiveRecord.php');
class CMSUser extends ActiveRecord implements Listable
{
	//DEFINE TABLE TO USE
	protected $key = 'user_id';
	protected $table = 'user';

	//DEFINE TABLE FILEDS, WITHOUT SYSTEM LIKE id or created
	protected $field_list = array(
		'user_id',
        'login',
        'password',
        'groups',
        'email'
	);

	//DEFINE VALIDATION SCHEMA, THAT IS CUSTOM, NOT REQUIRED
	protected $field_validation = array(
		'login' => 'va_login',
		//'broker_id' => 'va_broker_exists',
		//'broker_location_id' => 'va_broker_location_exists',
		//'agent_id' => 'va_agent_exists',
		//'department_id' => 'va_department_exists',
		//'user_name' => 'va_login',
		'groups' => 'va_empty',
		'email' => 'va_email'
	);

	//CUSTOM FIELD, THAT WILL BE USED BY LIST CLASS
	protected $order_by = 'ag.login asc ';

	//CUSTOM FILED THTAT WILL BE USED BY LIST
	protected $column_defs = array(
		//array('key' => 'user_id', 'label' => 'Id','sortable' => true),
		array('key' => 'login', 'label' => 'User name','sortable' => true),
		//array('key' => 'first_name', 'label' => 'First name','sortable' => true),
		//array('key' => 'last_name', 'label' => 'Last name','sortable' => true),
        array('key' => 'email', 'label' => 'E-Mail','sortable' => true),
		array('key' => 'groups', 'label' => 'Group','sortable' => true),
                
		array('key' => 'functions', 'label' => 'Functions', 'sortable' => false, 'field' => 'user_id','formatter' => 'user.function_formatter'),
	);

	protected $meta_class = array(
	/*
		'broker_location_id' => array('class' => 'RealEstate_Agent', 'field' => 'broker_location_id', 'f_key' => 'agent_id'),
		'broker_id' => array('class' => 'RealEstate_Location', 'field' => 'broker_id', 'f_key' => 'broker_location_id'),
		'user_type' => array('class' => 'RealEstate_Agent', 'field' => 'user_type', 'f_key' => 'agent_id'),
		'agent_first_name' => array('class' => 'RealEstate_Agent','field' => 'first_name', 'f_key' => 'agent_id'),
		'global_type' => array('class' => 'RealEstate_Agent','field' => 'global_type', 'f_key' => 'agent_id'),
		'agent_last_name' => array('class' => 'RealEstate_Agent', 'field' => 'last_name','f_key' => 'agent_id'),
		'assistant_first_name' => array('class' => 'User_AgentAssistant','field' => 'first_name','f_key' => 'assistant_id'),
		'assistant_last_name' => array('class' => 'User_AgentAssistant','field' => 'last_name','f_key' => 'assistant_id'),
	*/
		);

	//CUSTOM FIELD THAT WILL BE USED BY LIST
	protected $source_fields = array(
		'user_id','login','password', 'groups', /*'first_name', 'last_name',*/ 'email'
	);

	function get_source_fields()
	{
		return $this->source_fields;
	}

	function get_list_sql()
	{
		$sql = ' 	*
					FROM #p#user as u 
					';
		return $sql;
	}

	function get_column_defs()
	{
		return $this->column_defs;
	}

	function __construct($id = null)
	{
		parent::__construct($id);
	}

	function validate(&$data)
	{
		//need to validate data for broker
		$GLOBALS['core.application']->init_module('validator_module', true);
                $GLOBALS['core.validator.user_id'] = $this->user_id;
		foreach ($this->field_validation as $key => $value)
		{
			if(!isset($data[$key]))
				$data[$key] = '';
			$GLOBALS['core.validator']->add($key,$data[$key], '', $value);
		}
		$err = $GLOBALS['core.validator']->check();
		
		if (/*$this->user_id == null ||*/ isset($data['user_password'], $data['user_password_retype']))
		{
			
			$password = (isset($data['user_password']))?$data['user_password']:'';
			$password_retype = (isset($data['user_password_retype']))?$data['user_password_retype']:'';
			if (empty($password)) $err['user_password'] = 1;
			if ($password != $password_retype) $err['user_password_retype'] = 1;
		}		
		return $err;
	}
        function validate_password(&$data)
	{
		
		$GLOBALS['core.application']->init_module('validator_module', true);

		if (isset($data['user_password'], $data['user_password_retype']))
		{
                        //$GLOBALS['core.validator.user_id'] = $this->user_id;
			//pp($this->user_id);
                        //pp($GLOBALS['core.validator.user_id']);
			$password = (isset($data['user_password']))?$data['user_password']:'';
			$password_retype = (isset($data['user_password_retype']))?$data['user_password_retype']:'';
			if (empty($password)) $err['user_password'] = 1;
			if ($password != $password_retype) $err['user_password_retype'] = 1;
		}
		return $err;
	}
        function validate_last_user()
	{

		$GLOBALS['core.application']->init_module('validator_module', true);
                //pp($this->user_id);
                $users = $GLOBALS['core.sql']->getAll("SELECT * FROM #p#user WHERE user_id!=?",$this->user_id,'user_id');
                $err['isLastUser'] = true;
                foreach ($users as $key=>$value)
                {
                    $groups = explode(',',$value['groups']);
                    foreach($groups as $value)
                    {
                        if($value=='admin')
                        {
                            $err['isLastUser'] = false;
                            break;
                        }
                    }
                   
                }
                

		return $err;
	}
	
	function validate_assistant(&$data)
	{
		$GLOBALS['core.application']->init_module('validator_module', true);
		$err = array();
		$login = (isset($data['login']))?$data['login']:'';
		if (empty($login))
		{
			$err['login'] = 1;
		}
		else 
		{
			$user_id = $GLOBALS['core.sql']->getOne("SELECT user_id FROM #p#user WHERE login=?",$login);
			if (($user_id and !$this->user_id) or ($user_id and $this->user_id and $this->user_id != $user_id)) $err['login'] = 1;
		}

		if ($this->user_id == null || isset($data['user_password'], $data['user_password_retype']))
		{
			if (isset($data['action']) && 'change_password' == $data['action'])
			{
				$err = array();
			}
			
			$password = (isset($data['user_password']))?$data['user_password']:'';
			$password_retype = (isset($data['user_password_retype']))?$data['user_password_retype']:'';
			if (empty($password)) $err['user_password'] = 1;
			if ($password != $password_retype) $err['user_password_retype'] = 1;
		}
		return $err;		
	}

	function prepare_filters($filters)
	{
		$to_return = array();
		//$to_return['login'] = array('f' => 'login', 'v' => 'admin');
		//$to_return['not_assistant'] = array('f' => 'assistant_id','v' => 0,'o' => '=');

		if (isset($filters['login']) && (!empty($filters['login'])))
		{
			$to_return['login'] = array('f' => 'login','v' => $filters['login'],'o'=>'like');
		}
        
		/*
		if (isset($filters['first_name']) && (!empty($filters['first_name'])))
		{
			$to_return['first_name'] = array('f' => 'first_name','v' => $filters['first_name'],'o'=>'like');
		}
                if (isset($filters['last_name']) && (!empty($filters['last_name'])))
		{
			$to_return['last_name'] = array('f' => 'last_name','v' => $filters['last_name'],'o'=>'like');
		}
		*/
		
        if (isset($filters['groups']) && (!empty($filters['groups'])))
		{
			$to_return['groups'] = array('f' => 'groups','v' => $filters['groups'],'o'=>'like');
		}
                if (isset($filters['email']) && (!empty($filters['email'])))
		{
			$to_return['email'] = array('f' => 'email','v' => $filters['email'],'o'=>'like');
		}
		

		
		#var_dump($to_return);
		return $to_return;
	}
	function set_data(&$data)
	{

		if (isset($data['groups']))$data['groups'] = join(',',$data['groups']);
               /* if (isset($data['password']) && isset($data['password_2']) && !empty($data['password']))
                {
                    $data['password'] = ($data['password'] == $data['password_2'])? $data['password']:null;
                    if(!is_null($data['password'])) $data['password'] = $this->make_password($data['password']);
                }*/
                
                //if (isset($data['login']))$data['login'] = $data['login'];
		if (isset($data['user_password']))$data['password'] = $this->make_password($data['user_password']);
		/*if ($this->user_type)
			$data['groups'] = $this->user_type;

		if (isset($data['action']) && 'change_password' == $data['action'] && !empty($data['password']))
		{
			$data_pass = array('password' => $data['password']);
			parent::set_data($data_pass);
			return 1;
		}*/
		parent::set_data($data);
	}
	function save()
	{
		$new = false;
		if($this->user_id == null)
		{
			$new = true;
		}
		else 
		{
			
		}
		if(!$this->get_data('groups'))
		{
			$data = array('groups' => 'agent');
			$this->set_data($data);
		}
		
		parent::save();
	}
	function make_password($str = '')
	{
		return md5($str);
	}

	function create_by_agent($agent_id)
	{
		$record = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#user WHERE agent_id=?',$agent_id);
		if(!empty($record))
		{
			$this->construct_by_data($record);
			return true;
		}
		return false;
	}
	
	function get_all()
	{
		return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#user ORDER BY login");
	}
	
	function get_access_rights($section = '')
	{
		$uar = new User_AccessRights();
		$keys = $uar->get_access_keys_by_section();
		
		$rights = $GLOBALS['core.sql']->getAll("SELECT * FROM #p#access_right WHERE user_id=?",array($this->user_id));
		#$access_rights = array();
		/*
		foreach ($rights as $key => $value)
		{
			#if (!isset($access_rights[$value['section']])) $access_rights[$value['section']] = array();
			#$access_rights[$value['section']][$value['key']] = $value['value'];
			$keys[$value['section']][$value['key']] = $value['value'];
		}
		*/
		#var_dump($keys);
		foreach ($keys as $s => $items)
		{
			foreach ($items as $k => $v)
			{
				$keys[$s][$k] = $this->get_user_access_right($s,$k);
				if (!$keys[$s][$k])
				{
					$d = new User_Department($this->department_id);
					$keys[$s][$k] = $d->get_access_right($s,$k);
				}
			}
		}
		#var_dump($keys);
		if (!$section)
		{
			#return $access_rights;

			return $keys;
		}
		else
		{
			#return $access_rights[$section];
			return $keys[$section];
		}
	}

	function clear_access_rights($section)
	{
		$GLOBALS['core.sql']->query("DELETE FROM #p#access_right WHERE user_id=? AND section=?",array($this->user_id,$section));
	}
	
	function get_access_right($section,$key)
	{
		$right = $GLOBALS['core.sql']->getOne("SELECT value FROM #p#access_right WHERE user_id=? AND section=? AND `key`=?",array($this->user_id,$section,$key));
		if (!$right)
		{
			$d = new User_Department($this->department_id);
			$right = $d->get_access_right($section,$key);
		}
		return $right;
	}
	
	function get_user_access_right($section,$key)
	{
		return $GLOBALS['core.sql']->getOne("SELECT value FROM #p#access_right WHERE user_id=? AND section=? AND `key`=?",array($this->user_id,$section,$key));
	}

	
	function get_allowed_sections()
	{
		$uar = new User_AccessRights();
		$keys = $uar->get_access_keys_by_section();
		$sections = array();
		foreach ($keys as $key => $value)
		{
			if (isset($value['view_section']))
			{
				$sections[$key] = $this->get_access_right($key,'view_section');
			}
		}
		#var_dump($sections);
		return $sections;
	}

	function get_user_id_by_agent($agent_id)
	{
		if (empty($agent_id))
			return null;
		$res = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#user WHERE agent_id = ? ', array($agent_id));
		if (isset($res['user_id']))
		{
			return $res['user_id'];
		}
		return null;
	}
	function have_access($action = 'edit_user')
	{

		if ($GLOBALS['core.auth.user']->is_member_of('admin'))
			return true;
			
		if ($action == 'delete_r')$action = 'delete_user';
		if ($action == 'edit')$action = 'edit_user';
			
		$u = new User_DepartmentUser($GLOBALS['core.auth.user']->data['user_id']);
		$access_rights = $u->get_access_rights('Departments');
		
		if (isset($access_rights[$action]) && 'yes' == $access_rights[$action])
		{
			return true;
		}
		
		return false;
	}
	
	function get_assistants_num()
	{
		return $GLOBALS['core.sql']->getOne("SELECT COUNT(*) FROM #p#assistant WHERE parent_id=? AND deleted=0",$this->user_id);
	}
	
	function get_sum_users()
	{
		$res = $GLOBALS['core.sql']->getRow('SELECT count(*) as sum FROM #p#user WHERE deleted = 0 AND groups <> "admin" ');
		if (isset($res['sum']))
			return $res['sum'];
		return 0;
	}
	
	function delete()
	{
		//need to move user to severed department
		parent::delete();
	}
}
?>