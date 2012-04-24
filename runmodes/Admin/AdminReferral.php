<?php
require_once('Admin_Header.php');
require_once('classes/UserHolder.php');
require_once('classes/Coupon/CouponHolder.php');
require_once('classes/CMS/SettingsHolder.php');

class AdminReferral extends Runmode 
{
	function AdminReferral()
	{
		parent::Runmode();
	}
	
	function process()
	{		
		$uh = new UserHolder();
		$users = $uh->getAll();
		
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			if (isset($_REQUEST['coupon_id']) && !empty($_REQUEST['coupon_id']))
			{
				$coupon = new CouponHolder($_REQUEST['coupon_id']);
				$coupon_data = $coupon->get_data();
				//pp($coupon_data);
				$sh = new SettingsHolder();
				$settings = $sh->getSettings();
				
				if (isset($_REQUEST['send']) && !empty($_REQUEST['send']))
				{
					foreach ($_REQUEST['send'] as $key => $value)
					{
						$GLOBALS['core.smarty']->assign('coupon', $coupon_data);
						$GLOBALS['core.smarty']->assign('user',$users[$key]);
						$email = $GLOBALS['core.smarty']->fetch('Emails/referral_coupon.tpl');
						
						$GLOBALS['core.mail']->init();
						$GLOBALS['core.mail']->addAddress($users[$key]['email']);
						$GLOBALS['core.mail']->setSubject('Referral coupon');
						$GLOBALS['core.mail']->setFrom($settings['remind_email']);
						$GLOBALS['core.mail']->setFromName($settings['remind_name']);
						$GLOBALS['core.mail']->isHTML(true);
						$GLOBALS['core.mail']->setBody($email);
						$GLOBALS['core.mail']->send();
					}
					
					$GLOBALS['core.smarty']->assign('coupon_sent', 1);
				}
			}
		}		
		
		$payments = $GLOBALS['core.sql']->getAll("select user_id, sum(total) as stotal from #p#payment group by user_id ",array(),'user_id');
		foreach ($users as $key => $value)
		{
			$users[$key]['referrals'] = array();
			$users[$key]['referrals_total'] = 0;
			foreach ($users as $k => $v)
			{
				if ($v['referral_id'] == $key)
				{
					$users[$key]['referrals'][$k] = 0;
					if (isset($payments[$k])) $users[$key]['referrals'][$k] = $payments[$k]['stotal'];
					$users[$key]['referrals_total'] += $users[$key]['referrals'][$k];
				}
			}
			$users[$key]['referrals_count'] = count($users[$key]['referrals']);
		}
		foreach ($users as $key => $value)
			if (empty($value['referrals_count'])) unset($users[$key]);
					
		usort($users, array('AdminReferral','cmp'));
		$GLOBALS['core.smarty']->assign('referral_users', $users);
		$ch = new CouponHolder();
		$coupons = $ch->getAll();
		$GLOBALS['core.smarty']->assign('coupons', $coupons);
		return Admin_Header::out('admin_referral');
	}
	
	function cmp($a, $b)
	{
		if($a['referrals_count'] > $b['referrals_count'])
		{
			return -1;
		}
		elseif($a['referrals_count'] < $b['referrals_count'])
		{
			return 1;
		}
		return 0;
	}
}

?>