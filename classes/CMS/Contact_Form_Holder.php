<?php
require_once('Data_Holder.php');
class Contact_Form_Holder extends Data_Holder_Simple 
{
	var $answer = array();
	var $types = '';
	function Contact_Form_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('contact_module_form',$key_info);
	}
	
	function set_answer($select_answer)
	{
		$this->answer = $select_answer;
	}
	function set_types($types)
	{
		$this->types = $types;
	}
	
	function init($table, $key_info)
	{
		parent::init($table,$key_info);
		$key_value = $this->get_key_value(); 
		if(!empty($key_value))
		{
			$this->answer = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_form_select WHERE element_id=? ORDER by id',array($this->get_key_value()));
			$this->types = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_form_filetype WHERE element_id=? ORDER by id',array($this->get_key_value()));
		}
		else 
		{
			$this->answer = array();
			$this->types = '';
		}
	}
	
	function get_data($field = '')
	{
		$data = parent::get_data($field);
		$data['answer'] = $this->answer;
		$data['file_type'] = $this->types;
		return $data;
	}
	
	function save()
	{
		parent::save();
		$GLOBALS['core.store']->delete('contact_module_form_select',array('key_name' => 'element_id', 'key_value' => $this->get_key_value()));
		if($this->data['field_type'] == 'select')
		{
			foreach ($this->answer as $key => $value)
			{
				$data_to_save = array();
				$data_to_save['element_id'] = $this->get_key_value();
				$data_to_save['name'] = $value;
				$GLOBALS['core.store']->save('contact_module_form_select',$data_to_save,array('key_name' => 'id'));
			}
		}
		//$GLOBALS['core.store']->delete('contact_module_form_select',array('key_name' => 'element_id', 'key_value' => $this->get_key_value()));
		$GLOBALS['core.store']->delete('contact_module_form_filetype',array('key_name' => 'element_id', 'key_value' => $this->get_key_value()));
		if($this->data['field_type'] == 'file')
		{
			$data_to_save = array();
			$data_to_save['element_id'] = $this->get_key_value();
			$data_to_save['name'] = $this->types;
			$GLOBALS['core.store']->save('contact_module_form_filetype',$data_to_save,array('key_name' => 'id'));
		}
	}
	
	function get_all($contact_id)
	{
		$fields = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_form WHERE contact_id=? ORDER BY order_id',array($contact_id));
		$to_select = array(0);
		$to_file = array(0);
		foreach ($fields as $key => $value) 
		{
			if($value['field_type'] == 'select')
			{
				$to_select[] = $value['id'];
			}
			elseif($value['field_type'] == 'file')
			{
				$to_file[] = $value['id'];
			}
		}
		$select_answer = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_form_select WHERE element_id in (' . join(',',$to_select) . ') ORDER BY id');
		$file_types = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_form_filetype WHERE element_id in (' . join(',',$to_file) . ') ORDER BY id');
		foreach ($fields as $key => $value)
		{
			if($value['field_type'] == 'select')
			{
				$fields[$key]['answer'] = array();
				foreach ($select_answer as $s_key => $s_value)
				{
					if($value['id'] == $s_value['element_id'])
					{
						$fields[$key]['answer'][] = $s_value['name'];
					}
				}
			}
			elseif ($value['field_type'] == 'file')
			{
				$fields[$key]['file_type'] = '';
				foreach ($file_types as $f_key => $f_value)
				{
					if($value['id'] == $f_value['element_id'])
					{
						$fields[$key]['file_type'] = $f_value['name'];
					}
				}
			}
		}
		return $fields;
	}
	
	
}
?>