<?php
require_once('Common_Header.php');
require_once('classes/UserHolder.php');
require_once('classes/RegistrationHelper.php');
require_once('classes/DropdownManager.php');
require_once('classes/SettingsHolder.php');

class Registration extends Runmode 
{
	function Registration()
	{
		$this->base_map[0] = 'referral_id';
		parent::Runmode();
		$GLOBALS['core.smarty']->assign('moo2',1);
	}
	
	function process()
	{
		if ((isset($_REQUEST['referral_id']) && !empty($_REQUEST['referral_id'])) || isset($_SESSION['referral_id'])) 
		{
			if (isset($_REQUEST['referral_id']) && !empty($_REQUEST['referral_id'])) $referral_id = $_REQUEST['referral_id'];
			if (isset($_SESSION['referral_id']) && !empty($_SESSION['referral_id'])) $referral_id = $_SESSION['referral_id'];
			$GLOBALS['core.smarty']->assign('referral_id', $referral_id);
		}
		
        $dm = new DropdownManager();
        $GLOBALS['core.smarty']->assign('hear_categories',$dm->get_hear_categories());
        if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
        {
            $data = array();
            $errors = array();
            $rh = new RegistrationHelper();
            $data = $rh->gatherData($_REQUEST);
            $errors = $rh->checkForErrors($data);

            if (empty($errors))
            {
                $rh->registerUser($data);                
                $GLOBALS['core.smarty']->assign('registered',1);
                if (isset($_SESSION['referral_id'])) unset($_SESSION['referral_id']);
            }
            else
            {
                $GLOBALS['core.smarty']->assign('reg_data',$data);
                $GLOBALS['core.smarty']->assign('reg_errors',$errors);
            }
        }
		
		return Common_Header::out('Common/registration');
	}

	function registrationInCheckout()
	{
		if ($GLOBALS['core.auth.user']->uid)
		{
			$conf = $GLOBALS['core.config']->get_config('templates');
			$url = $conf['common']['https_url'] . "Checkout.html";
			header("Location:".$url);
			return;
		}
		
		if (isset($_REQUEST['next']) && !empty($_REQUEST['next']))
		{
			if (isset($_REQUEST['reg_in_check']) && !empty($_REQUEST['reg_in_check'])
				&& ($_REQUEST['reg_in_check'] == 1 || $_REQUEST['reg_in_check'] == 2))
				{
					$_SESSION['reg_in_check'] = $_REQUEST['reg_in_check'];
					$conf = $GLOBALS['core.config']->get_config('templates');
					$url = $conf['common']['https_url'] . "Checkout.html";
					header("Location:".$url);
					return;
					//$GLOBALS['core.runmode']->init('Checkout');
					//$GLOBALS['core.runmode']->run();
					//return '';
				}
				else $GLOBALS['core.smarty']->assign('error','Please select option');
		}
		
		return Common_Header::out('User/RegistrationInCheckout');
	}

	function ajax_check_username()
	{
		$response = array('html' => '','success' => 1,'message' => 'Username is unavailable','available' => 0);
		if (isset($_REQUEST['q']['username']) && !empty($_REQUEST['q']['username']))
		{
			$rh = new RegistrationHelper();
			$res = $rh->check_username($_REQUEST['q']['username']);
			if ($res) 
			{
				$response['message'] = 'Username is available';
				$response['available'] = 1;
			}
		}
		$GLOBALS['core.ajax']->put_to_output($response);
	}		
}
?>