<?php
require_once('Data_Holder.php');

class GuestBookHolder extends Data_Holder
{
	function __construct($id = null)
	{
		$table = 'guestbook_posts';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	
	
	
	function getAll()
	{
		return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#".$this->table ." WHERE deleted = 0 ORDER BY created DESC", array(), 'id');
	}

        function getAnswerByPost($post_id) {
                return $GLOBALS['core.sql']->getRow("SELECT * FROM #p#guestbook_answers WHERE post_id = ?", array($post_id));
        }

        function addAnswer($data) {
                return $GLOBALS['core.store']->save("guestbook_answers", $data, array('key_name'=>'id'));
        }

        function deletePost() {
                return $GLOBALS['core.store']->save("guestbook_posts", array('deleted'=>1), array('key_name'=>'id', 'key_value'=>$this->key_info['key_value']));
        }

        function getAnswer($answer_id)
	{
		return $GLOBALS['core.sql']->getOne("SELECT answer FROM #p#guestbook_answers WHERE id=?", array($answer_id));
	}

        function updateAnswer($data) {
                return $GLOBALS['core.store']->save("guestbook_answers", array('answer'=>$data['answer']), array('key_name'=>'id', 'key_value'=>$data['answer_id']));
        }

        
	
	
}
?>