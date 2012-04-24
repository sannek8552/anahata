<?php
require_once('modules/ActiveRecord.php');
require_once('classes/Listable.php');

class PostingItem extends ActiveRecord implements Listable{
	//DEFINE TABLE TO USE
	protected $table = "nl_posting";
	protected $addition_sql = "";

	//DEFINE TABLE FILEDS, WITHOUT SYSTEM LIKE id or created
	protected $field_list = array(
		'title',
		'send_scheme_id',
		'state',
		'method_id',
  		'mail_id',
  		'process_info',
                'date_time',
                'type',
		'method',
	);

	//DEFINE VALIDATION SCHEMA, THAT IS CUSTOM, NOT REQUIRED
	protected $field_validation = array(		
	);
	
	protected $do_not_escape_html = array('process_info'); 

	//CUSTOM FIELD, THAT WILL BE USED BY LIST CLASS
	protected $order_by = 'title ASC';

	//CUSTOM FILED THAT WILL BE USED BY LIST
	protected $column_defs = array(
		array('key'=>'title', 'label'=>'Title', 'sortable'=>true),
		array('key'=>'state', 'label'=>'Status', 'sortable'=>true, 'formatter'=>'nlposting.state_formatter'),
                array('key'=>'method_title', 'label'=>'Method', 'sortable'=>true),
                //array('key'=>'recipient', 'label'=>'Recipient type', 'sortable'=>true),
                array('key'=>'date_time', 'label'=>'Date', 'sortable'=>true),
		array('key'=>'functions', 'label'=>'Functions', 'sortable'=>false, 'field'=>'id', 'formatter'=>'nlposting.function_formatter'),
	);

	protected $meta_class = array(
		'method' => array('class' => 'MethodItem', 'field'=>'title', 'f_key'=>'method_id'),
	);

	//CUSTOM FIELD THAT WILL BE USED BY LIST
	protected $source_fields = array(
		'id',
		'title',
		'state',
                'method_title',
                //'recipient',
                'date_time',
                'sent_to_all',
                
	);
		
	function get_source_fields(){
		return $this->source_fields;
	}

	function get_list_sql(){
		//$sql = "p.* FROM #p#nl_posting AS p ";
                $sql= "p.*, m.title as method_title FROM #p#nl_posting p LEFT JOIN #p#nl_method m ON m.id=p.method_id";
		return $sql.$this->addition_sql;
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
		
		$to_return['deleted'] = array('f'=>'p.deleted', 'v'=>'0');
		
		if(isset($filters['title']) && !empty($filters['title']))
			$to_return['title'] = array('f'=>'p.title', 'v'=>$filters['title'], 'o'=>'LIKE');

		if(isset($filters['state']) && !empty($filters['state']))
			$to_return['state'] = array('f'=>'p.state', 'v'=>$filters['state'], 'o'=>'IN');


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

	function start_posting()
	{
		$id = $this->id;
		if (!empty($id))
		{
			$posting = $this->get_data();
			//empty posting process table
			//with posting
			$GLOBALS['core.store']->delete('nl_posting_process', array('key_name' => 'posting_id', 'key_value' => $id));
			
			//prepare subscribers for sending
			
			//get subscribers that should receive this newsletter
			//check if we resend or start new posting
			$all_users = ($posting['state'] == 1) ? true : false;
			$users = $this->get_users($id, $all_users);
			
			//prepare users for nl_posting_process table
			$new_users = array();
			$tmp_five = $tmp;
			foreach ($users as $user)
			{
				$tmp = array();
				$tmp['name'] = $user['first_name'] . " " . $user['last_name'];
				$tmp['first_name'] = $user['first_name'];
				$tmp['last_name'] = $user['last_name'];
				$tmp['email'] = $user['email'];
				$tmp['text_type'] = $user['text_type'];
				$tmp['status'] = 0;
				$tmp['reason'] = '';
				$tmp['posting_id'] = $id;
				$tmp['user_id'] = $user['id'];
				
				$tmp_five[] = $tmp;
				if (count($tmp_five) == 500)
				{
					$new_users[] = $tmp_five;
					$tmp_five = array();
				}
			}
			
			if (count($tmp_five) > 0)	$new_users[] = $tmp_five;
			
			//copy subscribers to nl_posting_process table
			//use batches by 500 users per one sql query
			foreach ($new_users as $value)
			{
				$GLOBALS['core.store']->fast_insert('nl_posting_process', $value);
			}
		}
	}
	
	function stop_posting()
	{
		$id = $this->id;
		if (!empty($id))
		{
			$posting = $this->get_data();
			//empty posting process table
			//with posting
			$GLOBALS['core.store']->delete('nl_posting_process', array('key_name' => 'posting_id', 'key_value' => $id));
		}
	}
	
	function mark_as_send($user_id)
	{
		$id = $this->id;
		if (!empty($id))
		{
			$GLOBALS['core.store']->save('nl_posting_process', array('status' => 1), array('key_name' => 'id', 'key_value' => $user_id));
		}
	}
	
	function mark_as_not_send($user_id, $reason)
	{
		$id = $this->id;
		if (!empty($id))
		{
			if (empty($reason)) $reason = 'Reason not detected in mailer object';
			$GLOBALS['core.store']->save('nl_posting_process', array('reason' => $reason), array('key_name' => 'id', 'key_value' => $user_id));
		}		
	}
	
	function get_users($posting_id, $all_users = true)
    {           
        if (!$all_users) {
            $users = $GLOBALS['core.sql']->getAll(
                'SELECT DISTINCT u . * '.
                'FROM #p#nl_user u '.
                'INNER JOIN #p#nl_user_group_link ul ON ul.user_id = u.id '.
                'INNER JOIN #p#nl_posting_group_link AS pl ON pl.group_id = ul.group_id '.
                'AND pl.posting_id = ? '.
                'WHERE ul.user_id NOT '.
                'IN ('.
                    'SELECT DISTINCT sm.user_id '.
                    'FROM #p#nl_sent_mail sm '.
                    'WHERE sm.posting_id = ? '.
                ') '.
                'AND u.deleted     = 0 '.
                'AND u.unsubscribe = 0', array($posting_id,$posting_id));
        } 
        else 
        {
            $users = $GLOBALS['core.sql']->getAll(
                "SELECT u.* ".
                "FROM #p#nl_user AS u ".
                "WHERE u.id IN (".
                        "SELECT DISTINCT ul.user_id FROM #p#nl_user_group_link AS ul ".
                        "INNER JOIN #p#nl_posting_group_link AS pl ON pl.group_id=ul.group_id AND pl.posting_id=? ".
                        "WHERE u.deleted=0 AND u.unsubscribe=0 ".
                ") ORDER BY u.id",
            array($posting_id));
        }
   
        return $users;
	}
	
	function get_users_batch($start_index, $count)
	{
		$id = $this->id;
		if (!empty($id)) $users = $GLOBALS['core.sql']->getAll("SELECT * from #p#nl_posting_process WHERE posting_id = ? ORDER BY id ASC LIMIT $start_index, $count ",array($id));
		else $users = array();
		return $users;	
	}
	
	function get_users_batch_full()
	{
		$id = $this->id;
		if (!empty($id)) $users = $GLOBALS['core.sql']->getAll("SELECT * from #p#nl_posting_process WHERE posting_id = ? ORDER BY id ASC ",array($id));
		else $users = array();
		return $users;	
	}
}
?>