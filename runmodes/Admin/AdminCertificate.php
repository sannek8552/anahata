<?php
require_once('Admin_Header.php');
require_once('classes/CertificateHolder.php');
require_once('CategoryHolder.php');
require_once('classes/SettingsHolder.php');
require_once('classes/PurchasedCertificateHolder.php');

class AdminCertificate extends Runmode 
{
	function AdminCertificate()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
		$GLOBALS['core.smarty']->assign('current_menu', 'Administration');
	}
	
	function process()
	{
		//pp($_REQUEST);		
		$ch = new CertificateHolder();
		if (isset($_REQUEST['action']))
		{
			if ('add' == $_REQUEST['action'])
			{
				$this->load_lists();
				return Admin_Header::out('certificate/edit_certificate');
			}
			
			if ('edit' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$ch = new CertificateHolder($_REQUEST['id']);
					$GLOBALS['core.smarty']->assign('certificate',$ch->get_data());					
					$this->load_lists();
					return Admin_Header::out('certificate/edit_certificate');
				}
			}
			
			if ('save' == $_REQUEST['action'])
			{
				$data = $this->process_save();
				$id = null;
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))	$id = $_REQUEST['id'];				
				
				$ch = new CertificateHolder($id);
				$ch->set_data($data);
				$ch->save();
				$this->subcategory_picture($data,$ch->get_key_value());
			}
			
			if ('delete' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$ch = new CertificateHolder($_REQUEST['id']);
					$cdata = $ch->get_data();
					$ch->delete();
				}
			}

			if ('page' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))	$page = $_REQUEST['id'];
			}
		}
		
		$GLOBALS['core.list']->custom_init('certificate_list');
		$GLOBALS['core.list']->set_sql(' * from #p#certificate ');
		$GLOBALS['core.list']->set_param('items_per_page',10);
		$GLOBALS['core.list']->set_param('order_by',array('order_no'));
		
		$filters = array();
		$filters = $GLOBALS['core.list']->get_filters();		
		if (isset($_REQUEST['filter']) && !empty($_REQUEST['filter']))
		{
			if (isset($_REQUEST['subcategory_picture']) && !empty($_REQUEST['subcategory_picture']))
			{
				$filters['subcategory_picture'] = array('f' => 'subcategory_picture', 'v' => 1);
			}
			elseif (isset($filters['subcategory_picture'])) unset($filters['subcategory_picture']);			
			
			if (isset($_REQUEST['show_inactive']))
			{									
				if ($_REQUEST['show_inactive'] == 2)
				{
					if (isset($filters['show_inactive'])) unset($filters['show_inactive']);
				}
				else
				{
					$filters['show_inactive'] = array('f' => 'inactive', 'v' => $_REQUEST['show_inactive']);
				}
			}
		}
		
		$GLOBALS['core.list']->set_filters($filters);
		
		$GLOBALS['core.smarty']->assign('filters',$filters);
		
		if (!isset($page)) $page = 1;
		$certificates = $GLOBALS['core.list']->get_page($page);
		$info = $GLOBALS['core.list']->num_pages();
		$GLOBALS['core.smarty']->assign('pages_info',$info);
		$GLOBALS['core.smarty']->assign('certificates',$certificates);
		
		$this->load_lists();
		
		return Admin_Header::out('certificate/admin_certificate');
	}
	
	function process_save()
	{
		$data = array();
				
		if (isset($_REQUEST['name']) && !empty($_REQUEST['name'])) $data['name'] = $_REQUEST['name'];
		if (isset($_REQUEST['number'])) $data['number'] = $_REQUEST['number'];		
		if (isset($_REQUEST['price']))	$data['price'] = $_REQUEST['price'];		
		if (isset($_REQUEST['description']))	$data['description'] = $_REQUEST['description'];
		else $data['description'] = '';
		if (isset($_REQUEST['full_description']))	$data['full_description'] = $_REQUEST['full_description'];
		else $data['full_description'] = '';				
		if (isset($_REQUEST['inactive']) && !empty($_REQUEST['inactive'])) $data['inactive'] = 1;
		else $data['inactive'] = 0;		
		if (isset($_REQUEST['seo'])) $data['seo'] = $_REQUEST['seo']; 
		else $data['seo'] = '';		
		$data['subcategory_picture'] = (isset($_REQUEST['subcategory_picture']) && !empty($_REQUEST['subcategory_picture'])) ? 1 : 0;
		if (isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no'])) $data['order_no'] = $_REQUEST['order_no'];
		
		if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0)
		{
			$filename = $this->upload_file($_FILES['picture']['name'],'./pictures/');
			//$filename = md5(time().microtime());
			if (move_uploaded_file($_FILES['picture']['tmp_name'],'./pictures/'.$filename))
			{
				$sh = new SettingsHolder();
				$settings = $sh->getSettings();
								
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$ch = new CertificateHolder($_REQUEST['id']);
					$picture = $ch->get_data('picture');
					if (!empty($picture))
					{
						if (file_exists('./pictures/'.$picture)) unlink('./pictures/'.$picture);
					}
				}
				$data['picture'] = $filename;
			}
		}			
		return $data;
	}

	function subcategory_picture($data,$id)
	{
		if (isset($data['subcategory_picture']) && $data['subcategory_picture'] == 1)
		{
			$GLOBALS['core.sql']->query('update #p#product set subcategory_picture = ? where category_id = ? and id != ? ',array(0,$data['category_id'],$id));
		}
	}

	function load_lists()
	{
		
	}
	
	function upload_file($file, $filedirectory)
 	{
 		$ch = new CertificateHolder();
 		return $ch->upload_file($file, $filedirectory); 
 	}
 	
 	function approval()
 	{
 		if (isset($_REQUEST['action']) && 'approve' == $_REQUEST['action'])
 		{
 			if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
 			{
 				$cph = new PurchasedCertificateHolder($_REQUEST['id']);
 				$cph->approve();
 			}
 		} 		
 		
 		$GLOBALS['core.list']->custom_init('approval_certificate_list');
		$GLOBALS['core.list']->set_sql(' c.*, cert.name, cert.price, cert.number from #p#certificate_purchased as c inner join #p#certificate as cert on c.certificate_id = cert.id ');
		$GLOBALS['core.list']->set_param('items_per_page',10);
		$GLOBALS['core.list']->set_param('order_by',array('created desc'));
		
		//pp($_REQUEST);
		$filters = array();
		$filters = $GLOBALS['core.list']->get_filters();		
		if (isset($_REQUEST['filter']) && !empty($_REQUEST['filter']))
		{
			if (isset($_REQUEST['status']) && !empty($_REQUEST['status']))
			{
				if ($_REQUEST['status'] == 'Outstanding')
				{
					$filters['used'] = array('f' => 'c.used', 'v' => 0);
					if (isset($filters['status'])) unset($filters['status']);
				}
				else
				{ 
					$filters['status'] = array('f' => 'c.status', 'v' => $_REQUEST['status']);
					if (isset($filters['used'])) unset($filters['used']);
				}
			}
			else
			{
				if (isset($filters['status'])) unset($filters['status']);
				if (isset($filters['used'])) unset($filters['used']);
			}
		}
		
		$GLOBALS['core.list']->set_filters($filters);		
		$GLOBALS['core.smarty']->assign('filters',$filters);
		//pp($filters);
		if (!isset($page)) $page = 1;
		$certificates = $GLOBALS['core.list']->get_page($page);
		$info = $GLOBALS['core.list']->num_pages();
		$GLOBALS['core.smarty']->assign('pages_info',$info);
		$GLOBALS['core.smarty']->assign('certificates',$certificates);
 		
 		return Admin_Header::out('certificate/certificate_approval');
 		
 	}
}

?>