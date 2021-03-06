<?php
require_once('Common_Header.php');
require_once('GuestBookHolder.php');

class GuestBook extends Runmode
{
	var $items_per_page;
	
	function __construct()
	{

                $this->base_map[0] = 'page';
                $this->items_per_page = 10;
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;
		
		$gb = new GuestBookHolder();
                $posts = array();
                $posts = $gb->getAll();

		$isAdmin = isset($GLOBALS['core.auth.user']->groups['admin']) ? true : false;
                $GLOBALS['core.smarty']->assign('isAdmin', $isAdmin);
                //Постраничная навигация
		$page_count = ceil(count($posts) / $this->items_per_page);
		$page_array = array();
		for ($i = 1; $i <= $page_count; $i++) {
                    $page_array[$i] = $i;
                }
		$GLOBALS['core.smarty']->assign('page_array',$page_array);
		$GLOBALS['core.smarty']->assign('page',$page);
		$posts = array_slice($posts,($page - 1)*$this->items_per_page,$this->items_per_page);
                foreach ($posts as $key=>$value) {
                    $posts[$key]['answer'] = $gb->getAnswerByPost($value['id']);
                }
		$GLOBALS['core.smarty']->assign('posts',$posts);
                $GLOBALS['core.smarty']->assign('seo_data',array('page_title'=>'Гостевая книга'));

		return Common_Header::out('Common/guest_book');
	}

        function ajax_add_post() {
            $return['success'] = false;
            $data = array();
            $data['post']   = isset($_REQUEST['post'])   ? $_REQUEST['post']   : null;
            $data['author'] = isset($_REQUEST['author']) ? $_REQUEST['author'] : null;

            if (!empty($data['post']) && !empty($data['author'])) {
                $gb = new GuestBookHolder();
                $gb->set_data($data);
                $gb->save();
                $return['success'] = true;
                $return['html'] = '<div class="post">
                                        <div class="info"><span class="author">'.$data['author'].'</span> - <span class="date">'.date('d.m.Y', time()).'</span></div>
                                        <div class="body">'.$data['post'].'</div>
                                    </div>';
            }
            else {
                $return['errorMsg'] = 'Невозможно добавить сообщение';
            }

            echo json_encode($return);
            //exit;
            
        }

        function ajax_add_answer() {
            $return['success'] = false;
            $return['errorMsg'] = 'Невозможно добавить ответ';
            $data = array();
            $data['answer_id'] = isset($_REQUEST['answer_id'])   ? $_REQUEST['answer_id']   : null;
            $data['post_id']   = isset($_REQUEST['post_id'])   ? $_REQUEST['post_id']   : null;
            $data['answer']    = isset($_REQUEST['answer']) ? $_REQUEST['answer'] : null;

            if (!empty($data['answer'])) {
                if (!empty($data['answer_id'])) {
                    $gb = new GuestBookHolder();
                    $gb->updateAnswer($data);
                    $return['success'] = true;
                } elseif (!empty($data['post_id'])) {
                    unset($data['answer_id']);
                    $gb = new GuestBookHolder();
                    $gb->addAnswer($data);
                    $return['answer_id'] = $GLOBALS['core.sql']->last_id();
                    $return['success'] = true;
                }
            }

            echo json_encode($return);
            //exit;

        }

        function ajax_delete_post() {
            $return['success'] = false;
            $post_id = isset($_REQUEST['post_id'])   ? $_REQUEST['post_id']   : null;

            if (!empty($post_id)) {
                $gb = new GuestBookHolder($post_id);
                $gb->deletePost();
                $return['success'] = true;
            }
            else {
                $return['errorMsg'] = 'Невозможно удалить ответ';
            }

            echo json_encode($return);
            //exit;

        }

        function ajax_load_answer() {
            $answer_id = isset($_REQUEST['answer_id'])   ? $_REQUEST['answer_id']   : null;

            if (!empty($answer_id)) {
                $gb = new GuestBookHolder();
                echo $gb->getAnswer($answer_id);
            }
            else {
                echo '';
            }

        }

}

?>