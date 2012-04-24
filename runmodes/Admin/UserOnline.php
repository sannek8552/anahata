<?php
require_once('classes/UserHolder.php');
require_once('Admin_Header.php');

class UserOnline extends Runmode
{
	function __construct()
	{
		parent::Runmode();		
	}
	
	function process()
	{
		
		$dbh = $GLOBALS['core.sql'];
                $ses_data = $dbh->getAll("SELECT * FROM #p#session");
                $userids = array();
                $userids[$GLOBALS['core.auth.user']->uid] = $GLOBALS['core.auth.user']->uid;
                foreach ($ses_data as $value)
                {
                    $content = $this->decode_session($value['content']);
                    if (isset($content['_UID_'])) {
                        $userids[$content['_UID_']] = $content['_UID_'];
                    }
                }
                $onlineusers = $dbh->getAll("SELECT * FROM #p#user WHERE user_id IN (".join(',',$userids).")",array(),'user_id');

                foreach ($onlineusers as &$user)
                {
                    $groups = explode(',',$user['groups']);
                    $user['isadmin'] = 0;
                    foreach ($groups as $group)
                    {
                        if ($group == 'admin') {
                            $user['isadmin'] = 1;
                            break;
                        }
                    }
                }

                $GLOBALS['core.smarty']->assign('onlineusers',$onlineusers);

                return Admin_Header::out('user_online');
	}

        function decode_session($sess_string)
        {
            // save current session data
            //   and flush $_SESSION array
            $old = $_SESSION;
            $_SESSION = array();

            // try to decode passed string
            $ret = session_decode($sess_string);
            if (!$ret) {
                // if passed string is not session data,
                //   retrieve saved (old) session data
                //   and return false
                $_SESSION = array();
                $_SESSION = $old;

                return false;
            }

            // save decoded session data to sess_array
            //   and flush $_SESSION array
            $sess_array = $_SESSION;
            $_SESSION = array();

            // restore old session data
            $_SESSION = $old;

            // return decoded session data
            return $sess_array;
        }
	

}
?>