<?php
require_once('Admin_Tree.php');


class Structure extends Admin_Tree
{
	var $tree_holder;
	var $tpl_prefix = "Admin/";
	var $tpl = "Tree/structure";
	var $tpl_table = "Tree/structure_table.tpl";
	var $tpl_tab = "Tree/structure_table_tab.tpl";
	var $add_tpl = "Tree/structure_add.tpl";
	var $edit_tpl = "Tree/structure_edit.tpl";
	
	var $tree_holder_class_name = "Structure_Data";
	var $secure_class_name = "Secure";
	var $ajax_rm = 'ajax_admin_structure';
	var $cfg;
	var $sn;

	function Structure($cfg,$sn)
	{
		parent::Admin_Tree($cfg);
		$this->cfg = $cfg;
		$this->sn = $sn;
	}
	
	function process()
	{
		//$GLOBALS['core.smarty']->assign('current_menu','members');
		//$GLOBALS['core.smarty']->assign('current_sub','manage_drop_downs');
		$GLOBALS['core.smarty']->assign('json_cfg',json_encode($this->cfg));
		$GLOBALS['core.smarty']->assign('sn',$this->sn);
		if (isset($this->cfg['item_name'])) $GLOBALS['core.smarty']->assign('item_name',$this->cfg['item_name']);
		if (isset($this->cfg['max_level'])) $GLOBALS['core.smarty']->assign('max_level',$this->cfg['max_level']);
		//print json_encode($this->cfg);
		return parent::process();
	}
	
	function ajax_process()
	{
		if (isset($this->cfg['item_name'])) $GLOBALS['core.smarty']->assign('item_name',$this->cfg['item_name']);
		if (isset($this->cfg['max_level'])) $GLOBALS['core.smarty']->assign('max_level',$this->cfg['max_level']);
		if (isset($_REQUEST['q']['action']))
		{
			switch ($_REQUEST['q']['action'])
			{
				case 'init' :	
						$this->ajax_get_menus();
						break;
				case 'delete' :	
						$this->ajax_delete_menu();
						break;
				case 'refresh_menu' :	
						$this->ajax_refresh_menu();
						break;
				case 'refresh_tree' :	
						$this->ajax_refresh_tree();
						break;
				case 'menu_move_up' :	
						$this->ajax_move_up_menu();
						break;
				case 'menu_move_down' :	
						$this->ajax_move_down_menu();
						break;
				case 'get_add_form':
						$this->get_add_form();
						break;
				case 'save_item':
						$this->save_item();
						break;
				case 'get_edit_form':
						$this->ajax_edit_item();
						break;
				case 'update_item':
						$this->ajax_update_item();
						break;
				case 'get_html':
						$this->ajax_get_html();
						break;
				case 'order':
						$this->ajax_order_menu();		
						break;
				case 'get_part' :
						$this->ajax_get_part();		
						break;
			}
		}
	}
	
	function ajax_order_menu()
	{
		parent::ajax_order_menu();
	}
	
	function ajax_get_html()
	{
		parent::ajax_get_html();
	}
	
	function ajax_get_submenus()
	{
		parent::ajax_get_submenus();
	}
	
	function ajax_get_menus()
	{
		parent::ajax_get_menus();
	}
	
	function ajax_refresh_tree()
	{
		parent::ajax_refresh_tree();
	}
	
	function ajax_refresh_menu()
	{
		parent::ajax_refresh_menu();
	}
	
	function ajax_delete_menu()
	{
		parent::ajax_delete_menu();
	}
	
	function ajax_move_up_menu()
	{
		parent::ajax_move_up_menu();
	}
	
	function ajax_move_down_menu()
	{
		parent::ajax_move_down_menu();
	}
	
	function get_add_form()
	{
		$fields = parent::get_add_form();		
		$response = array();
		$response['success'] = 1;
		$response['html'] = "";
		foreach ($fields as $key => $value)
		{
			if (isset($value['type']) && 'richtext' == $value['type']) $response['js_text'] .= $this->tiny_load_text($value['request_name']);
		}
		if (isset($_REQUEST['q']))
		{
			$data = $_REQUEST['q'];
			if (isset($data['id']))
			{
				$GLOBALS['core.smarty']->assign('parent_id',$data['id']);
				$GLOBALS['core.smarty']->assign('ajax_rm',$this->ajax_rm);
				$GLOBALS['core.smarty']->assign('sn',$this->sn);
				
				$response['html'] = $GLOBALS['core.smarty']->fetch($this->tpl_prefix.$this->add_tpl);
				$response['success'] = 0;
			}
		}
		$GLOBALS['core.ajax']->put_to_output($response);
	}
	
	function save_item()
	{
		$response = array();
		$success = 1;
		if (isset($_REQUEST['q']) && $this->secure->secure_add($_REQUEST['q']))
		{
			$data = $_REQUEST['q'];
			if (isset($data['model']) && !empty($data['model']))
			{
				if (isset($data['parent_id']))/* && !empty($data['parent_id']) && $data['parent_id'] != 0)*/
				{
					if (!isset($data['description']) || empty($data['description'])) $data['description'] = "";
					$this->tree_holder->init();
					$prepare_data = array($this->tree_holder->parent_field => $data['parent_id'],$this->tree_holder->title_field => $data['model']);
					$this->prepare_set_data($prepare_data);
					$this->tree_holder->set_data($prepare_data);
					$this->tree_holder->save();
				}
			}
			else $success = 0;
		}
		$GLOBALS['core.ajax']->put_to_output(array('success' => $success));
	}
	
	function ajax_edit_item()
	{
		
		$response = array();
		$response['success'] = 1;
		$response['html'] = "";
		$response['js_text'] = "";
		
		if (isset($_REQUEST['q'])  && $this->secure->secure_update($_REQUEST['q']))
		{
			$data = $_REQUEST['q'];
			if (isset($data['id']))
			{
				$this->tree_holder->init($data['id']);
				$model = $this->tree_holder->get_data($this->tree_holder->title_field);				
				$description = $this->tree_holder->get_data('description');
				$fields = $this->prepare_edit($this->tree_holder);
				foreach ($fields as $key => $value)
				{
					if (isset($value['type']) && 'richtext' == $value['type']) 
					{
						$response['js_text'] .= $this->tiny_load_text($value['request_name'],$description);
					}
				}
				$GLOBALS['core.smarty']->assign('model',$model);
				$GLOBALS['core.smarty']->assign('id',$data['id']);
				$GLOBALS['core.smarty']->assign('ajax_rm',$this->ajax_rm);
				$GLOBALS['core.smarty']->assign('sn',$this->sn);
				
				$response['html'] = $GLOBALS['core.smarty']->fetch($this->tpl_prefix.$this->edit_tpl);
				$response['success'] = 0;
			}
		}
		$GLOBALS['core.ajax']->put_to_output($response);
	}
	
	function ajax_update_item()
	{
		$response = array();
		$success = 1;
		if (isset($_REQUEST['q']) && $this->secure->secure_update($_REQUEST['q']))
		{
			$data = $_REQUEST['q'];
			if (isset($data['model']) && !empty($data['model']))
			{
				if (isset($data['id']) && !empty($data['id'])/* && $data['id'] != 1*/)
				{
					if (!isset($data['description']) || empty($data['description'])) $data['description'] = "";
					$this->tree_holder->init($data['id']);
					$prepare_data = array($this->tree_holder->title_field => $data['model']);
					$this->prepare_set_data($prepare_data);
					$this->tree_holder->set_data($prepare_data);
					$this->tree_holder->save();
				}
			}
			else $success = 0;
		}
		$GLOBALS['core.ajax']->put_to_output(array('success' => $success));
	}
	
	
	function ajax_get_part()
	{
		$response = array();
		$response['success'] = 1;
		$response['after'] = "";
		$deep = 0;
		
		if (isset($_REQUEST['q']['id']))
		{
			$id = $_REQUEST['q']['id'];
			$this->tree_holder->init($id);
			$data = $this->tree_holder->get_data();
			if (isset($data[$this->tree_holder->parent_field]))
			{
				if ($data[$this->tree_holder->parent_field] == 0)
				{
					$sub = $this->tree_holder->get_submenus(1);
					if (isset($sub[1]['sub']))
					{
						$ret = $sub[1]['sub'];
						$GLOBALS['core.smarty']->assign('data',$ret);
					}
					$response['html'] = $GLOBALS['core.smarty']->fetch($this->tpl_prefix.$this->tpl_table);
				}
				else
				{
					if ($data[$this->tree_holder->parent_field] != 1)
					{
						//$sub = $this->tree_holder->get_submenus(1);
						$sub = $this->tree_holder->get_submenus(0);
						$found = 0;
						$deep = 0;
						//$parent_id = 1;
						$parent_id = 0;
						while ($found == 0) 
						{
							foreach ($sub as $key => $value)
							{
								if ($key == $id)
								{
									$found = 1;
									//if ($parent_id == "") $parent_id = $id;
									break;
								}
								else 
								{
									if (!isset($value['sub_ids'])) continue;
									else if (in_array($id,$value['sub_ids']))
									{
										$deep ++;
										$sub = $value['sub'];
										if ($parent_id == 0) $parent_id = $value[$this->tree_holder->key_info['key_name']];
										break;
									}
								}
							}
						}
					}
					else $parent_id = $id;
					$sub = $this->tree_holder->get_submenus($parent_id);
					if (isset($sub[$parent_id]['sub']))
					{
						$ret = $sub[$parent_id]['sub'];
						//$GLOBALS['core.smarty']->assign('padding',0);
						$GLOBALS['core.smarty']->assign('item',$sub[$parent_id]);
						$GLOBALS['core.smarty']->assign('cur_level',1);
						//$GLOBALS['core.smarty']->assign('data',$ret);
					}
					$response['html'] = $GLOBALS['core.smarty']->fetch($this->tpl_prefix.$this->tpl_tab);
					$response['after'] = $parent_id;
				}
			}
		}
		$GLOBALS['core.ajax']->put_to_output($response);
	}
	
	function tiny_load_text($editor_name,$value = '')
	{
		$to_print = '';
		/*
		$text_to_init=''.
    	'mode : "exact",  '.
	    'theme : "advanced",'.  
	    'plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,searchreplace,print,contextmenu,ibrowser",  '.
	    'theme_advanced_buttons1_add_before : "save,separator",  '.
	    'theme_advanced_buttons1_add : "fontselect,fontsizeselect",'.  
	    'theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",  '.
	    'theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",  '.
	    'theme_advanced_buttons3_add_before : "tablecontrols,separator",  '.
	    'theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,youtube,ibrowser",'.
	    'theme_advanced_toolbar_location : "top",  '.
	    'theme_advanced_toolbar_align : "left",  '.
	    'theme_advanced_path_location : "bottom",  '.
	    'plugin_insertdate_dateFormat : "%Y-%m-%d",  '.
	    'plugin_insertdate_timeFormat : "%H:%M:%S",  '.
	    'extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"';
	    */
		$text_to_init = ''.		
		'mode : "exact",'.
		'elements: "simple_module_contentid",'.
		'theme : "advanced",'.
		'plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",'.		
		'theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",'.
		'theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",'.
		'theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",'.
		'theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,ibrowser",'.
		'theme_advanced_toolbar_location : "top",'.
		'theme_advanced_toolbar_align : "left",'.
		'theme_advanced_statusbar_location : "bottom",'.
		'theme_advanced_resizing : true,'.
		'template_external_list_url : "lists/template_list.js",'.
		'external_link_list_url : "lists/link_list.js",'.
		'external_image_list_url : "lists/image_list.js",'.
		'media_external_list_url : "lists/media_list.js"';
			

	    $oninit = '';
	    if (!empty($value))
	    {
	    	$value = str_replace("'","&#039;",$value);
	    	//$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	    	$func = "tinyMCE.get('mce_editor_0').setContent('".$value."');";
	    	$oninit = ',oninit : function(){'.$func.'}';
	    }
	    $to_print .= 'tinyMCE.init({'.$text_to_init.',elements:"' .$editor_name  . '"'.$oninit.'});';
	    $to_print = str_replace("\n","",$to_print);
	    
	    return $to_print;
	}
}
?>