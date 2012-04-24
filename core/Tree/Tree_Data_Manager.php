<?php
require_once('Tree/Structure_Data.php');

class Tree_Data_Manager extends Module
{
	var $config = 'dropdown';
	
	function Tree_Data_Manager($cfg)
	{
	}
	
	function init()
	{
	}
	
	function run()
	{
	}

	function get_tree($sn)
	{
		$data = array();
		$conf = $GLOBALS['core.config']->get_config($this->config);
		if (isset($conf[$sn]))
		{
			$str = new Structure_Data($conf[$sn]);
			$data = $str->get_all();
		}
		return $data;
	}
	
	/*
	function get_makes_by_type($type = '')
	{
		if ($type == 'car' || $type == 'bike' || $type == 'boat')
		{
			require_once('Car_Model.php');
			$car = new Car_Model();
			return $car->get_makes($type);
		}
	}

	function get_lifestyles($type = '')
	{
		if ($type == 'car' || $type == 'bike' || $type == 'boat')
		{
			require_once('Lifestyle_Module.php');
			$style = new Lifestyle_Module();
			return $style->get_makes($type);
		}
	}

	function get_specialskills()
	{		
		require_once('Special_Skill.php');
		$style = new Special_Skill();
		$data = $style->get_submenus(1);
		if (isset($data[1]['sub']))	return $data[1]['sub'];
	}

	function get_cartypes($type = '')
	{
		if ($type == 'car' || $type == 'bike' || $type == 'boat')
		{
			require_once('Car_Type.php');
			$style = new Car_Type();
			return $style->get_makes($type);
		}
	}

	function get_car_type($subtype = 0)
	{
	  $dbh = $GLOBALS['core.sql'];
	  $prefix = $GLOBALS['core.store']->prefix;
	  $parent_id = $subtype;
	  $hierachy = array();
	  if ($subtype)
	  {
	    while($parent_id != 1)
	    {
	      array_unshift($hierachy,$parent_id);
	      $row = $dbh->getRow("SELECT id,parent_id FROM {$prefix}car_type WHERE id=?",array($parent_id));
	      $parent_id = $row['parent_id'];
	    }
	    return $hierachy;
	  }
	}
	*/
}