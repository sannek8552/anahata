<?php
require_once('Admin_Header.php');
require_once('classes/PriceHolder.php');

class AdminPrice extends Runmode 
{
	var $type_id = 20;
	
	function AdminPrice()
	{		
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
		$GLOBALS['core.smarty']->assign('current_menu', 'Administration');
	}
	
	function process()
	{
		 $types = $GLOBALS['core.sql']->getAll("select * from #p#dropdown where parent_id = ?",array($this->type_id),'id');
		 $GLOBALS['core.smarty']->assign('price_types',$types);

		 if (isset($_REQUEST['action'])) 
		 {
		 	if ('list' == $_REQUEST['action'])
		 	{
				 if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				 {
				 	$id = $_REQUEST['id'];
				 	if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
				 	{
				 		$data = array();
				 		$data['type_id'] = $id;
				 		if (isset($_REQUEST['height']))
				 		{
				 			//if (($_REQUEST['height'],".",0) !== false) $_REQUEST['height'] = "0".$_REQUEST['height'];
				 			if ($_REQUEST['height'][0] == '.') $_REQUEST['height'] = "0".$_REQUEST['height'];
				 			$data['height'] = $_REQUEST['height'];
				 		}
				 		if (isset($_REQUEST['width'])) 	
				 		{
				 			//if (strpos($_REQUEST['width'],".",0) !== false) $_REQUEST['width'] = "0".$_REQUEST['width'];
				 			if ($_REQUEST['width'][0] == '.') $_REQUEST['width'] = "0".$_REQUEST['width'];
				 			$data['width'] 	= $_REQUEST['width'];
				 		}
				 		if (isset($_REQUEST['price'])) 	$data['price'] 	= $_REQUEST['price'];
				 	
				 		$key_info = array('key_name' => 'id');
				 		if (isset($_REQUEST['price_id']) && !empty($_REQUEST['price_id'])) $key_info['key_value'] = $_REQUEST['price_id'];
				 			
				 		$GLOBALS['core.store']->save('price',$data,$key_info);
				 	}
				 }
		 	}
		 	if ('edit' == $_REQUEST['action'])
		 	{
		 		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		 		{
		 			$price_id = $_REQUEST['id'];		 			
		 			$price = $GLOBALS['core.sql']->getRow("select * from #p#price where id = ?",array($price_id));
		 			$id = $price['type_id'];
		 			
		 			$GLOBALS['core.smarty']->assign('price',$price);
		 		}
		 	}
		 	if ('delete' == $_REQUEST['action'])
		 	{
		 		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		 		{
		 			$ph = new PriceHolder($_REQUEST['id']);
		 			$ph->delete();
		 		}
		 	}
		 }
		 if (!isset($id))
		 {
		 	$t = array_shift($types);
		 	$id = $t['id'];
		 	array_unshift($types,$t);
		 }
		 
		 $GLOBALS['core.smarty']->assign('type_id',$id);
		 $prices = $GLOBALS['core.sql']->getAll("select * from #p#price where type_id = ?",array($id),'id');
		 $GLOBALS['core.smarty']->assign('prices',$prices);		 
		 return Admin_Header::out('admin_price');
	}
}
?>