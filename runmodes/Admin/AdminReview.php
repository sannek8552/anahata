<?php
require_once('Admin_Header.php');
require_once('classes/ReviewHolder.php');
require_once('classes/SettingsHolder.php');
require_once('classes/ProductHolder.php');

class AdminReview extends Runmode 
{
	var $items_per_page;
	
	function AdminReview()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'page';
		
		parent::Runmode();
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		if (isset($settings['review_admin_number']) && !empty($settings['review_admin_number'])) $this->items_per_page = $settings['review_admin_number'];
		else $this->items_per_page = 20;
	}
	
	function process()
	{
		if (isset($_REQUEST['action']))
		{
			if (isset($_REQUEST['page']) && !empty($_REQUEST['page']))
			{
				$rh = new ReviewHolder($_REQUEST['page']);
				if ('Approve' == $_REQUEST['action'])
				{
					$rh->set_data(array('approved' => 1));
					$rh->save();
				}
				elseif ('Unapprove' == $_REQUEST['action'])
				{
					$rh->set_data(array('approved' => 0));
					$rh->save();
				}
				elseif ('Delete' == $_REQUEST['action'])
				{
					$rh->delete();
				}
			}
			elseif('DoChecked' == $_REQUEST['action'])
			{
				$rh = new ReviewHolder();
				$reviews = $rh->getAll(0);
				
				foreach($reviews as $rev)
				{
					if(isset($_REQUEST["check".$rev['id']]) and isset($_REQUEST["actionType"]))
					{
						$array[]=$rev['id'];
					}
				}
				if(	'ApproveChecked' == $_REQUEST['actionType'] and isset($array))
				{
					$_rh = new ReviewHolder();
					$_rh->approveReviews($array);
				}
				elseif(	'UnapproveChecked' == $_REQUEST['actionType'] and isset($array))
				{
					$_rh = new ReviewHolder();
					$_rh->unapproveReviews($array);
				}
				elseif(	'DeleteChecked' == $_REQUEST['actionType'] and isset($array))
				{
					$_rh = new ReviewHolder();
					$_rh->deleteReviews($array);
				}
			}
		}
		
		$rh = new ReviewHolder();
		$reviews = $rh->getAll(0);
		if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id']))
		{
			$_SESSION['review_product_id'] = $_REQUEST['product_id'];				
		}
		elseif (isset($_REQUEST['product_id']) && isset($_SESSION['review_product_id'])) unset($_SESSION['review_product_id']);
		
		if (isset($_SESSION['review_product_id']) && !empty($_SESSION['review_product_id']))
		{
			foreach ($reviews as $key => $value)
				if ($value['product_id'] != $_SESSION['review_product_id']) unset($reviews[$key]);
			$GLOBALS['core.smarty']->assign('cur_product_id', $_SESSION['review_product_id']);
		}
		
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Page' && isset($_REQUEST['page']) && !empty($_REQUEST['page'])) $page = $_REQUEST['page'];
		else $page = 1;
		
		$page_count = ceil(count($reviews) / $this->items_per_page);
		$page_array = array();
		for ($i = 1; $i <= $page_count; $i++) $page_array[$i] = $i;
		$GLOBALS['core.smarty']->assign('page_array',$page_array);
		$GLOBALS['core.smarty']->assign('page',$page);
		
		$reviews = array_slice($reviews,($page - 1)*$this->items_per_page,$this->items_per_page);
		$GLOBALS['core.smarty']->assign('reviews', $reviews);
		
		$ph = new ProductHolder();
		$ph->loadAllProducts();
		
		return Admin_Header::out('admin_review');
	}
}

?>