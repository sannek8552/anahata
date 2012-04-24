<?php
require_once('classes/CMS/Contact_Form_Holder.php');
require_once('classes/CMS/Contact_Holder.php');
require_once('classes/CMS/Gallery_One_Picture_Holder.php');
class Page_Contact_Runmode extends Runmode 
{
	function Page_Contact_Runmode()
	{
		parent::Runmode();
	}
	
	function process()
	{
		$contact_holder = new Contact_Holder($_REQUEST['section']);

		$fields = Contact_Form_Holder::get_all($contact_holder->get_key_value());
		if(empty($fields))
		{
			//we have no fields set or contact form not exists
			$GLOBALS['core.smarty']->assign('no_contact_form',1);
		}
		
		

		if(isset($_REQUEST['save_' . $_REQUEST['section']]) && !empty($_REQUEST['save_' . $_REQUEST['section']]) && !empty($fields))
		{
			//contact form submitted, need to save data to database and send email
			$data = array('email' => (isset($_REQUEST['email'])) ? $_REQUEST['email'] : '',
						  'name' => (isset($_REQUEST['name'])) ? $_REQUEST['name'] : ''	);
			if(empty($data['email']))
			{
				print 'miss email field!';
				exit();
			}
			
			if(empty($data['name']))
			{
				print 'miss name field!';
				exit();
			}
			
			$entry = array();
			$iferror = array();
			$tmp_path = array();
			foreach ($fields as $key => $value)
			{
				if($value['field_type'] == 'textarea')
				{
					
					//$_REQUEST['field_' . $value['id']] = str_replace("\n",'<br/>',$_REQUEST['field_' . $value['id']]);
					$iferror[$value['id']] = $_REQUEST['field_' . $value['id']];
					//$entry .= '<b>' . $value['field_name'] . '</b>:' . $_REQUEST['field_' . $value['id']] . '<br/>';
					$entry[$value['field_name']] = $_REQUEST['field_'.$value['id']];
					
					
				}
				elseif ($value['field_type'] == 'checkbox')
				{
					if(isset($_REQUEST['field_' . $value['id']]))
					{
						$_REQUEST['field_' . $value['id']] = 'Checked';
					}
					else 
					{
						$_REQUEST['field_' . $value['id']] = 'Not checked';
					}
					//$entry .= '<b>' . $value['field_name'] . '</b>:' . $_REQUEST['field_' . $value['id']] . '<br/>';
					$entry[$value['field_name']] = $_REQUEST['field_'.$value['id']];
					$iferror[$value['id']] = $_REQUEST['field_' . $value['id']];
				}
				elseif ($value['field_type'] == 'email')
				{
					$iferror['email'] = $_REQUEST['email'];
				}
				elseif ($value['field_type'] == 'file')
				{
					//$iferror['file']
					$f = 1;
					$conf = $GLOBALS['core.config']->get_config('templates');
					$path = $conf['common']['stored_module'];
					$entry['stored_files'][$value['field_name']] = Gallery_One_Picture_Holder::check_file($_FILES['field_'.$value['id']]['name'], $path."contact_module/");
					$tmp_path['field_'.$value['id']]['tmp_name'] = $_FILES['field_'.$value['id']]['tmp_name'];
					$tmp_path['field_'.$value['id']]['name'] = '';
					while ($f == 1)
					{
						$f = 2;
						foreach ($tmp_path as $vv)
						{
							if($vv['name'] == $entry['stored_files'][$value['field_name']])
							{
								$entry['stored_files'][$value['field_name']] = rand(1, 99).$entry['stored_files'][$value['field_name']];
								$f = 1;
							}
						}
					}
					
					$tmp_path['field_'.$value['id']]['name'] = $entry['stored_files'][$value['field_name']];
				}
				elseif ($value['field_type'] == 'name')
				{
					$iferror['name'] = $_REQUEST['name'];
				}
				else 
				{
				//	$entry .= '<b>' . $value['field_name'] . '</b>:' . $_REQUEST['field_' . $value['id']] . '<br/>';
					$entry[$value['field_name']] = $_REQUEST['field_'.$value['id']];
					$iferror[$value['id']] = $_REQUEST['field_' . $value['id']];
				}
			}
			
			$data['entry'] = serialize($entry);
			$data['contact_id'] = $contact_holder->get_key_value();
			$can_save = true;
			if(isset($_REQUEST['protect']) && $_REQUEST['protect'] == 1)
			{
				
				if(isset($_REQUEST['check_captcha_' . $_REQUEST['section']]) && !empty($_REQUEST['check_captcha_' . $_REQUEST['section']]) && !empty($_SESSION['protect_' . $_REQUEST['section']]) && $_REQUEST['check_captcha_' . $_REQUEST['section']] == $_SESSION['protect_' . $_REQUEST['section']])
				{
					$can_save = true;
				}
				else 
				{
					$GLOBALS['core.smarty']->assign('wrong_captcha', 1);
					$can_save = false;
					$GLOBALS['core.smarty']->assign('iferror', $iferror);
				}
			}
			$sys_er = array();
			
			if(isset($_FILES) && count($_FILES) > 0)
			{				
				foreach ($_FILES as $key => $value)
				{
					$error_files = array('php', 'js', 'pl');
					$pathinfo = pathinfo($value['name']);
					$temp = split("_", $key);
					$file_types = Contact_Holder::get_error_files($temp[count($temp)-1]);
					
					$file_types = str_replace(" ", '', $file_types);
					$file_types = split(",", $file_types);
					
					
					if(count($file_types) > 0)
					{
						if(!in_array(strtolower($pathinfo['extension']), $file_types))
						{
							$can_save = false;
							$er[] = $temp[count($temp)-1];
							$GLOBALS['core.smarty']->assign('er', $er);
							$GLOBALS['core.smarty']->assign('iferror', $iferror);
						}
					}
					if(in_array(strtolower($pathinfo['extension']), $error_files))
					{
						$can_save = false;
						$er[] = $temp[count($temp)-1];
						$GLOBALS['core.smarty']->assign('er', $er);
						$GLOBALS['core.smarty']->assign('iferror', $iferror);
					}
					
					if($_FILES[$key]['error'] == UPLOAD_ERR_INI_SIZE)
					{
						$sys_er[$temp[count($temp)-1]] = 'File is too big';
					}
					elseif ($_FILES[$key]['error'] == UPLOAD_ERR_FORM_SIZE)
					{
						$sys_er[$temp[count($temp)-1]] = 'File is too big';
					}
					elseif ($_FILES[$key]['error'] == UPLOAD_ERR_PARTIAL)
					{
						$sys_er[$temp[count($temp)-1]] = "File hasn't uploaded completely" ;
					}
					elseif ($_FILES[$key]['error'] == UPLOAD_ERR_NO_FILE)
					{
						$sys_er[$temp[count($temp)-1]] = 'No file was uploaded';
					}
					elseif ((int)$_FILES[$key]['size'] == (int)0)
					{
						$sys_er[$temp[count($temp)-1]] = 'No file was uploaded';
					}
					if(count($sys_er) > 0)
					{
						$can_save = false;
						$GLOBALS['core.smarty']->assign('sys_er', $sys_er);
						$GLOBALS['core.smarty']->assign('iferror', $iferror);
					}
				}
			}
			if(true == $can_save)
			{				
				if(isset($tmp_path) && count($tmp_path) > 0)
				{
					$conf = $GLOBALS['core.config']->get_config('templates');
					$path = $conf['common']['stored_module'];
					foreach ($tmp_path as $k => $v)
					{
						move_uploaded_file($v['tmp_name'], $path."contact_module/".$v['name']);
					}
				}
				
				$GLOBALS['core.store']->save('contact_module_entry',$data,array('key_name' => 'id'));
				
				//after save this form need to send emails
				$GLOBALS['core.application']->init_module('mailer_module', true);
				$contact_data = $contact_holder->get_data();
	
				$GLOBALS['core.mail']->setFrom($contact_data['from_email']);
				$GLOBALS['core.mail']->setFromName($contact_data['from_name']);
				$GLOBALS['core.mail']->setSubject($contact_data['subject']);
				$GLOBALS['core.mail']->isHTML(true);
	
				$GLOBALS['core.smarty']->assign('mail_text', $contact_data['mail_text']);
				//pp(unserialize($entry));
				$GLOBALS['core.smarty']->assign('entry', unserialize($data['entry']));
				$GLOBALS['core.smarty']->assign('email' , $data['email']);
				$GLOBALS['core.smarty']->assign('name' , $data['name']);
				$body = $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/contact_module_mail.tpl');
				$GLOBALS['core.mail']->setBody($body);
	
				$GLOBALS['core.mail']->addAddress($data['email']);
				$GLOBALS['core.mail']->send();

				if (isset($_SESSION['HTTP_REFERER'])) $GLOBALS['core.smarty']->assign('http_referer',$_SESSION['HTTP_REFERER']);			
				$GLOBALS['core.smarty']->assign('to_admin', 1);
				$body = $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/contact_module_mail.tpl');

                                $GLOBALS['core.application']->init_module('mailer_module', true);
				//$contact_data = $contact_holder->get_data();

				$GLOBALS['core.mail']->setFrom($data['email']);
				$GLOBALS['core.mail']->setFromName($data['name']);
				$GLOBALS['core.mail']->setSubject($contact_data['subject']);
				$GLOBALS['core.mail']->isHTML(true);
				$GLOBALS['core.mail']->setBody($body);
				$GLOBALS['core.mail']->addAddress($contact_data['from_email']);
				$GLOBALS['core.mail']->send();
				//now we need to direct user to Thank yoy page
				$t_conf = $GLOBALS['core.config']->get_config('templates');
				//header("Location:" . $t_conf['script_url'] . 'Thank_You/' . $GLOBALS['core.CMS.seo_url'] . '.html');
				
				unset($_SESSION['protect_' . $_REQUEST['section']]);
				//here we assume that we use seo url, support for not seo urls will be added later, hopefully we will not require it
				//exit();
				header("Location:" . $t_conf['common']['script_url'] . $contact_data['thank_you_page'] . '.html');
				return ;
			}
		}
		
		unset($_SESSION['protect_' . $_REQUEST['section']]);
		$GLOBALS['core.smarty']->assign('fields', $fields);
		$GLOBALS['core.smarty']->assign('section', $_REQUEST['section']);
		//pp($_REQUEST);
		if(isset($_REQUEST['template']) && $_REQUEST['template'] == 'tiny')
		{
			return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/contact_module_tiny.tpl');
		}
		if(isset($_REQUEST['protect']) && $_REQUEST['protect'] == 1)
		{
			$GLOBALS['core.smarty']->assign('show_captcha', 1);
		}
                if(isset($_REQUEST['section']) && $_REQUEST['section'] == 2)
		{
			$GLOBALS['core.smarty']->assign('default_values', 1);
		}
		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/contact_module.tpl');
	}
} 
?>