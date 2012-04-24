<?php
require_once('Common_Header.php');
require_once('classes/WishlistHelper.php');
require_once('classes/ProductHolder.php');
require_once('classes/Specials/SpecialHolder.php');

class Wishlist extends Runmode 
{
	function Wishlist()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		
		parent::Runmode();
	}
	
	function process()
	{
		$user_id = $GLOBALS['core.auth.user']->data['user_id'];
		
		
		
		if (isset($_REQUEST['action']) && !empty($_REQUEST['action']))
		{
			if ('delete' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$product = new ProductHolder($_REQUEST['id']);
					$message = $product->removeFromWishlist($user_id);
					$GLOBALS['core.smarty']->assign('message',$message);
				}
			}
		}
		
		
		$wh = new WishlistHelper();
		$pids = $wh->getProducts($user_id);
		$GLOBALS['core.smarty']->assign('pids',$pids);
		
		$sh = new SpecialHolder();
		$specials = $sh->calculateAllSpecials();
		
		$ph = new ProductHolder();
		$ph->load_lists();
		$products = $ph->getAll();
		
		foreach ($products as $key => $value)
		{
			if ($value['inactive'] == 1) {unset($products[$key]);continue;}
			if (isset($specials[$key])) $products[$key] = $specials[$key];
		}
		
		$GLOBALS['core.smarty']->assign('products',$products);

		return Common_Header::out('Common/wishlist');
	}
}

?>