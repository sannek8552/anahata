<?php
class Page_Strategy
{
	var $page_item = null;
	function Page_Strategy($page_item, $id = null)
	{
		$this->page_item = $page_item;
	}
	
	function strategy()
	{
		//print_r($_REQUEST);
		$to_return = array();
		if(isset($_REQUEST['step']) && 'prev' == $_REQUEST['step'])
		{
			$res = $this->page_item->next_step(-1);
		}
		elseif(isset($_REQUEST['step']) && 'next' == $_REQUEST['step'])
		{
			$res = $this->page_item->next_step(1);
		}
		elseif (isset($_REQUEST['step']) && 'display' == $_REQUEST['step'])
		{
			$res = $this->page_item->display($_REQUEST['edit_id']);
			$res = $res['content'];
		}
		elseif (isset($_REQUEST['step']) && 'info' == $_REQUEST['step'])
		{
			$res = $this->page_item->info($_REQUEST['edit_id']);
			$res = $res['content'];
		}
		elseif (isset($_REQUEST['step']) && 'active' == $_REQUEST['step'])
		{
			$res = $this->page_item->active($_REQUEST['edit_id'],$_REQUEST['active']);
			$res = $res['content'];
		}		
		elseif (isset($_REQUEST['step']) && 'publish' == $_REQUEST['step'])
		{
			$res = $this->page_item->publish($_REQUEST['edit_id'],$_REQUEST['active']);
			$res = $res['content'];
		}				
		else 
		{
			$res = $this->page_item->first_step();
		}
		if($this->page_item->is_final())
		{
			$to_return['final'] = 'true';
			$to_return['final_params'] = $this->page_item->final_step();
		}
		$params_back = $this->page_item->params_to_back();
		$to_return['content'] = $res;
		$to_return['params_to_back'] = $params_back;
		return $to_return;
	}
}
?>