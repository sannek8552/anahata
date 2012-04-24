<?php
require_once('Common_Header.php');
require_once('classes/CertificateHolder.php');
require_once('classes/CategoryHolder.php');
require_once('classes/CMS/SettingsHolder.php');
require_once('classes/BrandHolder.php');

class Certificate extends Runmode 
{
	function Certificate()
	{
		$this->base_map[0] = 'id';
		$this->base_map[1] = 'action';		
		$this->base_map[2] = 'second_action_id';
		parent::Runmode();
		
		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			if (!is_numeric($_REQUEST['id']))
			{
				$ch = new CertificateHolder();				
				if ($ch->loadBySeo($_REQUEST['id']))
				{
					$_REQUEST['id'] = $ch->get_key_value();
				}
			}
		}
	}
	
	function process()
	{
		$sh = new SettingsHolder();
       	$settings = $sh->getSettings();
		
        if (isset($_REQUEST['id']))
        {
            $id = $_REQUEST['id'];
        	$quantity = 1;
			if (isset($_REQUEST['action']) && 'EditCart' == $_REQUEST['action'])
			{
                if (isset($_SESSION['cart'][$_REQUEST['id']]))
                {
                    $GLOBALS['core.smarty']->assign('cart_id',$_REQUEST['id']);
                    $cart_info = $_SESSION['cart'][$_REQUEST['id']];
                    $id = $cart_info['product_id'];
                    $GLOBALS['core.smarty']->assign('cart_info',$cart_info);                    
                    $cr = new CertificateHolder($id);
                    $cd = $cr->get_data();
                }
                else
                {
            		$GLOBALS['core.runmode']->init('Cart');
					$GLOBALS['core.runmode']->run();
					return;
                }
			}
			
			if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
			{
                $bool = $this->process_save($id);
				//redirect to cart runmode				
                $certificate = new CertificateHolder($id);                
                $certificate_data = $certificate->get_data();
                $_SESSION['continue_shopping_url'] = "Category/Certificates.html";
                
                if ($bool)
                {                             
                	header("Location:Cart.html");
                	return ;
                }
                else 
                {
                	
                }
            }

            $ch = new CertificateHolder($id);
            $cdata = $ch->get_data();                    
            if (!empty($cdata))
            {
                $GLOBALS['core.smarty']->assign('pdata',$cdata);
                $this->load_lists();
                $GLOBALS['core.smarty']->assign('q',$quantity);
                
                $category = new CategoryHolder();
                $category->loadByUrl('Certificates');
                $GLOBALS['core.smarty']->assign('certificate_category', $category->get_data());
            }
        }
		return Common_Header::out('Common/certificate');
	}
	
	function process_save($id)
	{
		$ch = new CertificateHolder($id);
		$cdata = $ch->get_data();
        		
		$data = array();
		$add_to_cart = true;
		
		$error_message = "";
		$data['quantity'] = 1;        
		$data['price'] = $cdata['price'];        
		$data['product_id'] = $id;
		$data['certificate'] = 1;
		$data['person_name'] = $_REQUEST['person_name'];
		$data['person_email'] = $_REQUEST['person_email'];
		$data['person_comment'] = $_REQUEST['person_comment'];
                    
		if ($add_to_cart && $data['price'] > 0)
		{
			if (!isset($_SESSION['cart'])) $_SESSION['cart'] = array();
			if (isset($_REQUEST['cart_id'])) $_SESSION['cart'][$_REQUEST['cart_id']] = $data;
			else $_SESSION['cart'][] = $data;
		}

		if (isset($_REQUEST['cart_id'])) $GLOBALS['core.smarty']->assign('cart_id', $_REQUEST['cart_id']);
		$GLOBALS['core.smarty']->assign('error_message', $error_message);
		$GLOBALS['core.smarty']->assign('request', $_REQUEST);
		
		return $add_to_cart;
	}

	function load_lists()
	{
		
	}
}
?>