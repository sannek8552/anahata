<?php
require_once('classes/BaseList.php');
require_once('classes/NewsLetter/PostingItem.php');
require_once('classes/NewsLetter/GroupOptions.php');
//require_once('classes/NewsLetter/StatusOptions.php');
require_once('classes/NewsLetter/ContactOptions.php');
require_once('classes/NewsLetter/Process.php');

class PostingList extends BaseList{
	protected $list_name = 'posting';

	protected $page_size	= 20;
	protected $default_sort	= 'title';
	protected $default_dir	= 'ASC';
	protected $holder_class	= 'PostingItem';

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
		$groups_holder = new PostingGroup();
                //$contact_holder = new PostingContact();
                //$status_holder = new PostingStatus();
               foreach ($page as $key => $value)
                {
                    /* switch ($value['type'])
                    {
                        
                        case 'group':
                            $groups = $groups_holder->get_posting_groups_string($value['id']);
                            $page[$key]['recipient'] = 'Groups: '.$groups;
                            break;
                        
                        case 'status':

                            $statuses = $status_holder->get_posting_statuses_string($value['id']);
                            $page[$key]['recipient'] = 'Statuses: '.$statuses;
                            break;
                        
                        case 'contact':
                            $contacts = $contact_holder->get_posting_contacts_string($value['id']);
                            $page[$key]['recipient'] = 'Contacts: '.$contacts;
                            break;
                        default:
                            break;
                    }*/

                    $page[$key]['date_time'] = date("d/m/Y H:i:s", $value['date_time']);
                    $page[$key]['sent_to_all'] = $this->sent_to_all($value);
                }

	}
        
        function sent_to_all($posting)
        {
            $sent_to_all = true;
            $had_sent = $GLOBALS['core.sql']->getRow("SELECT * FROM #p#nl_posting_history WHERE posting_id = ?",array($posting['id']));
            if ($had_sent) {
            	$posting_obj = new PostingItem();
                $users = $posting_obj->get_users($posting['id'], false);
                if (!empty($users)) 
                {
                    $sent_to_all = false;
                }
            }
            return $sent_to_all;
        }
}
?>