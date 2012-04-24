<?php
require_once('classes/BaseList.php');
require_once('classes/NewsLetter/ReadReportItem.php');
require_once('classes/NewsLetter/UserItem.php');

class UnsubscribeReportList extends BaseList{
	protected $list_name = 'unsubscribe_report';

	protected $page_size	= 20;
	protected $default_sort	= 'unsubscribe_date';
	protected $default_dir	= 'ASC';
	protected $holder_class	= 'UnsubscribeReportItem';

	function __construct(){
		parent::__construct();
	}

	function getAll($filters = array()){
		$filters['deleted'] = 0;
		$filters = $this->holder_instance->prepare_filters($filters);
		$parts = $GLOBALS['core.list']->prepare_filters($filters);
		$sort_field = $this->default_sort;
		return $GLOBALS['core.sql']->getAll(
			'SELECT '.$this->get_sql().
			' WHERE '.$parts['sql_part'].
			' ORDER BY '.$sort_field,
			$parts['modif']);
	}

        function post_process(&$page)
        {

                foreach ($page as $key => $value)
                {
                    /*switch ($value['type'])
                    {
                        case 'group':
                            $user_holder = new UserItem($value['user_id']);
                            $users = $user_holder->get_data();
                            $page[$key]['first_name'] = $user_holder->__get('first_name');
                            $page[$key]['last_name']  = $user_holder->__get('last_name');
                            $page[$key]['email']      = $user_holder->__get('email');;
                            break;

                        case 'contact':
                            $email = $GLOBALS['core.sql']->getOne('SELECT email FROM #p#contact_module_entry WHERE id=?',array($value['contact_entry_id']));
                            $page[$key]['first_name'] = '';
                            $page[$key]['last_name']  = '';
                            $page[$key]['email']      = $email;
                            break;
                        
                        default:
                            break;
                    }*/
                    if (!empty($value['unsubscribe_date']))
                    	$page[$key]['unsubscribe_date'] = date("d/m/Y H:i:s", $value['unsubscribe_date']);
                    else $page[$key]['unsubscribe_date'] = '-';	
                }

	}
        
}
?>