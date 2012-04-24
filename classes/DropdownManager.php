<?php


class DropdownManager
{	
	var $type_id = 20;
	var $position_id = 8;
	var $font_id = 9;
	var $hear_id = 2;
	
	function DropdownManager()
	{
		
	}
	
	function get_price_categories()
	{
		$res = $GLOBALS['core.sql']->getAll("select * from #p#dropdown where parent_id = ? order by order_id ",array($this->type_id),'id');
		return $res;
	}
	
	function get_position_categories()
	{
		$res = $GLOBALS['core.sql']->getAll("select * from #p#dropdown where parent_id = ? order by order_id ",array($this->position_id),'id');
		return $res;
	}
	
	function get_font_categories()
	{
		$res = $GLOBALS['core.sql']->getAll("select * from #p#dropdown where parent_id = ? order by order_id ",array($this->font_id),'id');
		return $res;
	}
	
	function get_hear_categories()
	{
		$res = $GLOBALS['core.sql']->getAll("select * from #p#dropdown where parent_id = ? order by order_id ",array($this->hear_id),'id');
		return $res;
	}
	
	function load_lists()
	{
		$types = $this->get_price_categories();
		$GLOBALS['core.smarty']->assign('price_categories',$types);
		
		$fonts = $this->get_font_categories();
		$GLOBALS['core.smarty']->assign('font_categories',$fonts);
		
		$positions = $this->get_position_categories();
		$GLOBALS['core.smarty']->assign('position_categories',$positions);
		
		$hears = $this->get_hear_categories();
		$GLOBALS['core.smarty']->assign('hear_categories',$hears);
	}
}
?>