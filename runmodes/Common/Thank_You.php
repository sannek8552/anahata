<?php
require_once('Common_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/CertificateHolder.php');

class Thank_You extends Runmode 
{
	function Thank_You()
	{
		$this->base_map[0] = 'trid';
		$this->base_map[1] = 'deposit';
 		parent::Runmode();
	}
	
	function process()
	{
		//print_r($_REQUEST);
		if (isset($_REQUEST['trid']) && !empty($_REQUEST['trid']))
		{
			$transaction = $GLOBALS['core.sql']->getRow("select * from #p#payment where transaction_id = ? ",array($_REQUEST['trid']));
			
			if (isset($transaction['google_analytics']) && empty($transaction['google_analytics']))
			{
				$transaction['products'] = unserialize($transaction['cart_info']);
				$GLOBALS['core.smarty']->assign('transaction', $transaction);
				
				$ph = new ProductHolder();
				$products = $ph->getAll();
				$GLOBALS['core.smarty']->assign('products',$products);
				
				$options = $ph->getAllOptionsAdm();
				$GLOBALS['core.smarty']->assign('options',$options);						
				
				$ch = new CertificateHolder();
				$certificates = $ch->get_all();
				$GLOBALS['core.smarty']->assign('certificates', $certificates);
				
				$item_shippings = $GLOBALS['core.sql']->getAll("select * from #p#item_shipping order by created ",array(),'id');
				$GLOBALS['core.smarty']->assign('item_shippings',$item_shippings);
				
				$GLOBALS['core.sql']->query(" update #p#payment set google_analytics = ? where id = ?", array(1, $transaction['id']));
			}
		}
		
		if (isset($_REQUEST['trid']) && isset($_REQUEST['deposit']))
		{
			$GLOBALS['core.smarty']->assign('trid',$_REQUEST['trid']);
			$deposit = $GLOBALS['core.sql']->getRow("select * from #p#deposit");
			$GLOBALS['core.smarty']->assign('deposit',$deposit);				
									
			return Common_Header::out('Common/finish_deposit');
		}
		elseif(isset($_REQUEST['trid']))
		{			
			$GLOBALS['core.smarty']->assign('trid',$_REQUEST['trid']);
			return Common_Header::out('Common/card_info');
		}
	}
}
?>