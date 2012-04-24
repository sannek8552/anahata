<?php
require_once('Data_Holder.php');
require_once('classes/CMS/Contact_Form_Holder.php');
require_once('classes/CSV.php');

class Contact_Holder extends Data_Holder_Simple 
{
	function Contact_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('contact_module',$key_info);
	}
	
	function get_module_list()
	{
		$to_ret = array();
		$res = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module ORDER BY id',array(),'id');
		foreach ($res as $key => $value)
		{
			$to_ret[] = array('code'=> '[contact_module?section=' . $value['id'] . ']','description' => $value['subject']);
			$to_ret[] = array('code'=> '[contact_module?section=' . $value['id'] . '&protect=1]','description' => $value['subject'] . '<br/>With captcha');
		}
		return $to_ret;
	}
	
	function get_all()
	{
		$res = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module ORDER BY id',array(),'id');
		foreach ($res as $key => $value)
		{
			$count = $GLOBALS['core.sql']->getOne('SELECT count(*) FROM #p#contact_module_entry WHERE contact_id=?',array($value['id']));
			$res[$key]['count'] = $count;
		}
		return $res;
	}
	
	function &get_formholder($id)
	{
		$form_holder = new Contact_Form_Holder($id);
		$form_holder->set_data(array('contact_id' => $this->get_key_value()));
		return $form_holder;
	}
	
	function delete()
	{
		$k_v = $this->get_key_value();
		if(is_null($k_v))
			return;
		$ids = $GLOBALS['core.sql']->getAll('SELECT id FROM #p#contact_module_entry WHERE contact_id = ?', array($this->get_key_value()));
		
		if(count($ids) > 0 )
		{
			foreach ($ids as $v)
			{
				self::delete_files($v['id']);
			}
		}
		$GLOBALS['core.store']->delete('contact_module_entry',array('key_name' => 'contact_id', 'key_value' => $this->get_key_value()));
		
		$selects = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_form WHERE contact_id=? AND field_type=?',array($this->get_key_value(),'select'));
		$filetypes = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_form WHERE contact_id=? AND field_type=?',array($this->get_key_value(),'file'));
		$GLOBALS['core.store']->delete('contact_module_form',array('key_name' => 'contact_id','key_value' => $this->get_key_value()));
		
		$to_delete = array(0);
		foreach ($selects as $key => $value)
		{
			$to_delete[] = $value['id'];
		}
		$GLOBALS['core.sql']->query('DELETE FROM #p#contact_module_form_select WHERE element_id IN (' . join(',', $to_delete) . ')');
		
		$to_delete = array((0));
		foreach ($filetypes as $key => $value)
		{
			$to_delete[] = $value['id'];
		}
		$GLOBALS['core.sql']->query('DELETE FROM #p#contact_module_form_filetype WHERE element_id IN (' . join(',', $to_delete) . ')');
		//$GLOBALS['core.sql']->deltete('contact_module_form_filetype', array('key_name' => 'element_id', 'key_value' => $this->get_key_value()));
		parent::delete();
	}
	
	function delete_files($id)
	{
		$entry = Contact_Holder::get_entry_by_id($id);
		if(isset($entry['entry']))
		{
			$entry = unserialize($entry['entry']);
			if(isset($entry['stored_files']) && count($entry['stored_files']) > 0)
			{
				$conf = $GLOBALS['core.config']->get_config('templates');
				$path = $conf['common']['stored_module'];
				foreach ($entry['stored_files'] as $value)
				{

					if(file_exists($path."contact_module/".$value))
					{
						unlink($path."contact_module/".$value);
					}
				}
			}
		}
	}
	
	function get_entries()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_entry WHERE contact_id=? ORDER BY id desc',array($this->get_key_value()));

	}
	function get_entry_by_id($id)
	{
		return $GLOBALS['core.sql']->getRow('SELECT * FROM #p#contact_module_entry WHERE id=?', array($id));
	}
	
	function delete_entry($entry_id)
	{
		$GLOBALS['core.sql']->query('DELETE FROM #p#contact_module_entry WHERE contact_id=? AND id=?',array($this->get_key_value(),$entry_id));
	}
	function save()
	{
		$bb=false;
		if(is_null($this->get_key_value()))
		{
			$bb=true;
		}
		parent::save();
		if ($bb)
		{
			$data_field = array();
			$data_field['field_name'] = 'Email';
			$data_field['field_type'] = 'email';
			$data_field['field_validation'] = 'email';
			$data_field['field_error'] = 'Enter valid email';
			$data_field['order_id'] = 0;
			$form_holder = $this->get_formholder(null);
			$form_holder->set_data($data_field);
			$form_holder->save();
			
			$data_field = array();
			$data_field['field_name'] = 'Name';
			$data_field['field_type'] = 'name';
			$data_field['field_validation'] = 'name';
			$data_field['field_error'] = 'Enter name';
			$data_field['order_id'] = 1;
			$form_holder = $this->get_formholder(null);
			$form_holder->set_data($data_field);
			$form_holder->save();
		}
	}
	function make_csv()
	{
		$entries = array();
		$entries = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#contact_module_entry WHERE contact_id=?', array($this->get_key_value()));
		if(count($entries) > 0)
		{
			foreach ($entries as $key => $value)
			{
				$entries[$key]['entry'] = unserialize($value['entry']);
			}
			//pp($entries);
			//$entries = Csv_parser::parse_csv($entries);
			$output = array();
			foreach ($entries as $key => $value)
			{
				
				$output[$key]['id'] = $value['id'];
				$output[$key]['email'] = $value['email'];
				if(count($value['entry']) > 0)
				{
					foreach ($value['entry'] as $k => $v)
					{
						$output[$key][$k] = $v;
					}
				}
				$output[$key]['Date'] = date("D M j G:i:s ", $value['created']);
				
			}
			$filename = 'contact_'.$entries[0]['contact_id'].'.csv';
			$GLOBALS['core.smarty']->assign('head', CSV::create_csv_file_header($output));
			$file = CSV::getCsvFile_grobokop($output, $filename);
			// We'll be outputting a PDF
			header('Content-type: text/csv');
			
			// It will be called downloaded.pdf
			header("Content-Disposition: attachment; filename=".$filename."");
			// The PDF source is in original.pdf
			print $file;
			
			
		}
		
		//$output = CSV::convertToExcelCSV($output);
		
		
		//$output = CSV::getCsv($output);
		return '';
	
	}
	function get_error_files($element_id)
	{
		return $GLOBALS['core.sql']->getOne('SELECT name FROM #p#contact_module_form_filetype WHERE element_id = ?', array($element_id));
	}
	function delete_file_types($element_id)
	{
		$GLOBALS['core.store']->delete('contact_module_form_filetype', array('key_name' => 'element_id', 'key_value' => $element_id));
	}
}
?>