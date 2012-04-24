<?php
require_once("Tree_Holder.php");

class Structure_Data extends Tree_Holder 
{
	var $table ;
	var $key_info ;
	var $parent_field;
	var $order_field ;
	var $title_field ;	
	var $data;
	
	function Structure_Data($cfg)
	{
		/*
			table=register_dropdown
			parent_field=parent_id
			order_field=order_id
			title_field=title
			max_level=2
		*/
		//$this->init($id);
		if (!isset($cfg['table']) || empty($cfg['table']))	return PEAR::raiseError('no table specified');
		$this->table = $cfg['table'];
		if (isset($cfg['id_field']) && !empty($cfg['id_field'])) $this->key_info['key_name'] = $cfg['id_field'];
		else $this->key_info['key_name'] = 'id';
		if (isset($cfg['parent_field']) && !empty($cfg['parent_field'])) $this->parent_field = $cfg['parent_field'];
		else $this->parent_field = 'parent_id';
		if (isset($cfg['order_field']) && !empty($cfg['order_field'])) $this->order_field = $cfg['order_field'];
		else $this->order_field = 'order_id';
		if (isset($cfg['title_field']) && !empty($cfg['title_field'])) $this->title_field = $cfg['title_field'];
		else $this->title_field = 'title';
		
	}
	
	function init($id)
	{
		return parent::init($id);
	}

	function get_data($field_name = '')
	{
		return parent::get_data($field_name);
	}

	function set_data($data)
	{
		parent::set_data($data);
	}

	function save()
	{
		return parent::save();
	}

	function delete()
	{
		return parent::delete();
	}

	function get_all($filters = array(), $additional = array())
	{
		return parent::get_all($filters, $additional);
	}
	
	function get_submenus($parent_id,$filters = array())
	{
		return parent::get_submenus($parent_id,$filters);
	}
}
?>