<?php
require_once('modules/ActiveRecord.php');
require_once('classes/Listable.php');

class UserItem extends ActiveRecord implements Listable{
	//DEFINE TABLE TO USE
	protected $table = "nl_user";
	protected $sql = "u.* FROM #p#nl_user AS u ";
        //protected $sql = "u.*, g.title as groups FROM #p#nl_user u LEFT JOIN #p#nl_user_group_link ug ON ug.user_id=u.id LEFT JOIN #p#nl_group g ON ug.group_id = g.id ";

	//DEFINE TABLE FILEDS, WITHOUT SYSTEM LIKE id or created
	protected $field_list = array(
		'created',
		'first_name',
		'last_name',
		'postcode',
                'email',
                'old_email',
		'text_type',
		'unsubscribe',
                'unsubscribe_date'
	);

	//DEFINE VALIDATION SCHEMA, THAT IS CUSTOM, NOT REQUIRED
	protected $field_validation = array(		
	);

	//CUSTOM FIELD, THAT WILL BE USED BY LIST CLASS
	protected $order_by = 'first_name asc';

	//CUSTOM FILED THAT WILL BE USED BY LIST
	protected $column_defs = array(
		array('key'=>'first_name',	'label'=>'First Name',	'sortable'=>true),
		array('key'=>'last_name',	'label'=>'Last Name',	'sortable'=>true),
		array('key'=>'email',		'label'=>'E-mail',	'sortable'=>true),
		array('key'=>'postcode',	'label'=>'Postcode',	'sortable'=>true),
        array('key'=>'groups',      'label'=>'Groups',	'sortable'=>false),
        array('key'=>'groups_id',   'label'=>'Groups id',	'sortable'=>false),
        array('key'=>'text_type',	'label'=>'Letter type',	'sortable'=>true, 'formatter' => 'nluser.text_type_formatter'),
		array('key'=>'unsubscribe',	'label'=>'Unsubscribed','sortable'=>true, 'formatter' => 'nluser.unsubscribe_formatter'),
		array('key'=>'functions',	'label'=>'Functions',	'sortable'=>false, 'field'=>'id', 'formatter'=>'nluser.function_formatter'),
                array('key'=>'checkbox',	'label'=>'<input type="checkbox" class="yui-dt-checkbox" name="select_all" id="select_all" onclick="check_all();" style="width:auto;"/>','field'=>'id','sortable'=>false, 'resizeable'=>false,'formatter'=>'nluser.checkbox_formatter'),
	);

	protected $meta_class = array(
//		'country' => array('class' => 'Location','field' => 'title','f_key' => 'country_id'),
	);

	//CUSTOM FIELD THAT WILL BE USED BY LIST
	protected $source_fields = array(
		'id',
		'first_name',
		'last_name',
		'email',
		'postcode',
        'groups',
        'groups_id',
		'text_type',
		'unsubscribe',
	);
		
	function get_source_fields(){
            //pp($this->source_fields);exit();
		return $this->source_fields;
                
	}

	function get_list_sql(){
                //pp($this->sql);exit();
		return $this->sql;
	}

	function get_column_defs(){
		return $this->column_defs;
	}

	function __construct($id = null){
		parent::__construct($id);
	}

	function validate(&$data){
		//need to validate data for broker
		$GLOBALS['core.application']->init_module('validator_module', true);
		foreach ($this->field_validation as $key => $value){
			if(!isset($data[$key]))
				$data[$key] = '';
			$GLOBALS['core.validator']->add($key, $data[$key], '', $value);
		}
		$err = $GLOBALS['core.validator']->check();	
		return $err;
	}

	function prepare_filters($filters){
		$to_return = array();
		
		$to_return['deleted'] = array('f'=>'u.deleted', 'v'=>'0');
		
		if(isset($filters['first_name']) && !empty($filters['first_name']))
			$to_return['first_name'] = array('f'=>'u.first_name', 'v'=>$filters['first_name'], 'o'=>'LIKE');
		if(isset($filters['last_name']) && !empty($filters['last_name']))
		
			$to_return['last_name'] = array('f'=>'u.last_name', 'v'=>$filters['last_name'], 'o'=>'LIKE');
		if(isset($filters['email']) && !empty($filters['email']))
		
			$to_return['email'] = array('f'=>'u.email', 'v'=>$filters['email'], 'o'=>'LIKE');

		if(isset($filters['group']) && $filters['group']>0){
			$this->sql .= "INNER JOIN #p#nl_user_group_link AS l ON l.user_id=u.id ";
			$to_return['group'] = array('f'=>'l.group_id', 'v'=>$filters['group']);
		}
		
		return $to_return;
	}
	
	function get_data($name = null){
		$data = parent::get_data($name);
		//if($name=='price') $data = number_format($data, 2, '.', ' ');
                return $data;
	}

	function set_data($data){
		return parent::set_data($data);
	}
	
	function mail_unique($mail, $id=null){
		$values = array($mail);
		if($id) $values[] = $id;

		return $GLOBALS['core.sql']->getOne(
			"SELECT count(*) FROM #p#nl_user WHERE email=? ".
			($id ? "AND id<>?" : ''),
			$values);
	}

        function already_imported($email)
        {
            return $GLOBALS['core.sql']->getOne("SELECT id FROM #p#nl_user WHERE email = ? OR old_email = ?",array($email,$email));
        }

        
}
?>