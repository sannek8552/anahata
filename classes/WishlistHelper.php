<?php


class WishlistHelper
{
	var $table = 'wishlist';
	
	function WishlistHelper()
	{
		
	}
	
	function addToWishlist($product_id,$user_id)
	{
		$id = $GLOBALS['core.sql']->getOne("select * from #p#".$this->table." where user_id = ? and product_id = ?",array($user_id,$product_id));
		if (!empty($id)) return "Product already in wishlist";
		$GLOBALS['core.store']->save('wishlist',array('user_id' => $user_id, 'product_id' => $product_id),array('key_name' => 'id'));
		return '';
	}
	
	function removeFromWishlist($product_id,$user_id)
	{
		$id = $GLOBALS['core.sql']->getOne("select * from #p#".$this->table." where user_id = ? and product_id = ?",array($user_id,$product_id));
		if (empty($id)) return 'Product is not in your wishlist';
		$GLOBALS['core.store']->delete($this->table,array('key_name' => 'id','key_value' => $id));
		return 'Product was removed from your wishlist';
	}
	
	function isInWishlist($product_id, $user_id)
	{
		$id = $GLOBALS['core.sql']->getOne("select * from #p#".$this->table." where user_id = ? and product_id = ?",array($user_id,$product_id));
		return (!empty($id));
	}

	function getProducts($user_id)
	{
		return $GLOBALS['core.sql']->getAll('select * from #p#'.$this->table.' where user_id = ?',array($user_id));
	}
}


?>