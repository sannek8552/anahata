<?php
require_once('Admin_Header.php');
require_once('classes/SettingsHolder.php');

class AdminSettings extends Runmode 
{
	var $settings = array(							
							array( 	'title' => 'Image size',									
									'save_name' => 'save_image',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'height', 'alias' => 'Height', 'type' => 'int'),
														array('name' => 'width', 'alias' => 'Width', 'type' => 'int'),
														array('name' => 'color', 'alias' => 'Color', 'type' => 'string'),
														array('name' => 'tip_height', 'alias' => 'Large version height', 'type' => 'int'),
														array('name' => 'tip_width', 'alias' => 'Large version width', 'type' => 'int'),
														array('name' => 'tip_color', 'alias' => 'Large version color', 'type' => 'string')
												)
							),
							
							array( 	'title' => 'Cross products Image size',
									'save_name' => 'save_cross_image',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'cross_height', 'alias' => 'Height', 'type' => 'int'),
														array('name' => 'cross_width', 'alias' => 'Width', 'type' => 'int'),
														array('name' => 'cross_tip_height', 'alias' => 'Tip Height', 'type' => 'int'),
														array('name' => 'cross_tip_width', 'alias' => 'Tip Width', 'type' => 'int')
												)
							),
							
							array( 	'title' => 'Option image size',
									'save_name' => 'save_option_image',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'option_height', 'alias' => 'Height', 'type' => 'int'),
														array('name' => 'option_width', 'alias' => 'Width', 'type' => 'int'),
														array('name' => 'option_color', 'alias' => 'Color', 'type' => 'string'),
														array('name' => 'option_tip_height', 'alias' => 'Large version height', 'type' => 'int'),
														array('name' => 'option_tip_width', 'alias' => 'Large version width', 'type' => 'int'),
														array('name' => 'option_tip_color', 'alias' => 'Large version color', 'type' => 'string')
												)
							),
							
							array(	'title' => 'Remind password',
									'save_name' => 'save_remind',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'remind_email','email' => 1, 'alias' => 'From email', 'type' => 'string'),
														array('name' => 'remind_name', 'alias' => 'From name', 'type' => 'string'),
														array('name' => 'remind_subject', 'alias' => 'Subject', 'type' => 'string')
												)
							),
							
							array( 	'title' => 'Payment options',
									'save_name' => 'save_payment',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'deposit', 'alias' => 'Enable direct deposit', 'type' => 'bool'),
														array('name' => 'paypal', 'alias' => 'Enable paypal', 'type' => 'bool'),
														array('name' => 'credit_card', 'alias' => 'Enable credit card', 'type' => 'bool')
												)
								
							),
							
							array(	'title' => 'Emails',
									'save_name' => 'save_email',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'direct_deposit_email','email' => 1, 'alias' => 'Direct deposit payment notification send to', 'type' => 'string'),
														array('name' => 'direct_deposit_from_email','email' => 1, 'alias' => 'Direct deposit payment info send from', 'type' => 'string'),
														array('name' => 'direct_deposit_from_name', 'alias' => 'Direct deposit payment info send from name', 'type' => 'string'),
														array('name' => 'credit_card_email','email' => 1, 'alias' => 'Credit card payment notification send to', 'type' => 'string'),
														array('name' => 'credit_card_from_email','email' => 1, 'alias' => 'Credit card payment info send from', 'type' => 'string'),
														array('name' => 'credit_card_name', 'alias' => 'Credit card payment info send from name', 'type' => 'string')
												)
							),
							
							array(	'title' => 'Items per page',
									'save_name' => 'save_items',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'products_per_page', 'alias' => 'Products per page', 'type' => 'string'),
														array('name' => 'categories_per_page', 'alias' => 'Categories per page', 'type' => 'string'),
														array('name' => 'rows_per_category', 'alias' => 'Rows per category', 'type' => 'string'),
														array('name' => 'columns_per_category', 'alias' => 'Columns per category', 'type' => 'string')
												)
							),
							
							array(	'title' => 'Online store menu',
									'save_name' => 'save_store',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'show_on_top','alias' => 'Show on top menu','type' => 'bool'),
														array('name' => 'show_on_left','alias' => 'Show on left menu','type' => 'bool')
												)
							),
							
							array(	'title' => 'Featured',
									'save_name' => 'save_featured',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'featured_per_page','alias' => 'Featured products per page','type' => 'int')														
												)
							),
							array(	'title' => 'Coupon Settings',
									'save_name' => 'save_coupon',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'coupon_product', 'alias' => 'Coupon Product','type' => 'int'),
														array('name' => 'coupon_category','alias' => 'Coupon Category','type' => 'int')														
												)
							),
							
							array(	'title' => 'Different Features',
									'save_name' => 'save_feature',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'use_out_of_stock', 'alias' => 'Use out of stock','type' => 'bool'),
														array('name' => 'low_stock_limit', 'alias' => 'Low stock limit','type' => 'int'),
														array('name' => 'low_stock_notify', 'alias' => 'Notify admin about low stock', 'type' => 'bool'),
														array('name' => 'low_stock_email','email' => 1, 'alias' => 'Email to notify about low stock', 'type' => 'string')
									)
								),
									
							array(	'title' => 'Discount points',
									'save_name' => 'save_discount_points',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'discount_point', 'alias' => 'Value of one discount point (e.g 0.2 mean 20 cents)','type' => 'string'),
														array('name' => 'discount_limit', 'alias' => 'Minimum limit of discount amount (AUD)','type' => 'int')
									)		
							),
							
							array(	'title' => 'New products',
									'save_name' => 'save_new_products',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'new_product_days', 'alias' => 'Count of days during product is new','type' => 'int')
									)
							),
                            array(  'title' => 'SMTP settings',
                                            'save_name' => 'smtp_settings',
                                            'success_message' => 'Settings changed',
                                            'fields' => array(
                                                                                    array('name' => 'smtp_check', 'alias' => 'SMTP send', 'type' => 'bool'),
                                                                                    array('name' => 'smtp_admin_register_email','email' => 1, 'alias' => 'Admin Email', 'type' => 'string'),
                                                                                    array('name' => 'smtp_admin_from_email','email' => 1, 'alias' => 'From Email', 'type' => 'string'),
                                                                                    array('name' => 'smtp_admin_from', 'alias' => 'From Name', 'type' => 'string'),
                                                                                    array('name' => 'smtp_admin_subject', 'alias' => 'Admin Subject', 'type' => 'string'),
                                                                                    array('name' => 'smtp_server', 'alias' => 'SMTP server', 'type' => 'string'),
                                                                                    array('name' => 'smtp_port', 'alias' => 'SMTP port', 'type' => 'int'),
                                                                                    array('name' => 'smtp_username', 'alias' => 'Username', 'type' => 'string'),
                                                                                    array('name' => 'smtp_password', 'alias' => 'Password', 'type' => 'string')

                                            )

                            ),
                            array( 	'title' => 'Reviews',
									'save_name' => 'save_reviews',
									'success_message' => 'Settings changed',
									'fields' => array(														
														array('name' => 'reviews_only_logged', 'alias' => 'Reviews only by logged users', 'type' => 'bool'),
														array('name' => 'review_number', 'alias' => 'Count of reviews per page', 'type' => 'int'),
														array('name' => 'review_admin_number', 'alias' => 'Count of reviews per page for admin', 'type' => 'int'),
														array('name' => 'review_admin_email','email' => 1, 'alias' => 'Notification email', 'type' => 'string'),
														array('name' => 'review_admin_subject', 'alias' => 'Notification subject', 'type' => 'string')
												)
								
							),
							
							array( 	'title' => 'Tell a Friend',
									'save_name' => 'save_friend',
									'success_message' => 'Settings changed',
									'fields' => array(														
														array('name' => 'friend_site_name', 'alias' => 'Name of site', 'type' => 'string'),
														array('name' => 'friend_subject', 'alias' => 'Subject of email', 'type' => 'string'),
														array('name' => 'friend_captcha', 'alias' => 'Turn captcha on', 'type' => 'bool')
												)
							),
                            
							array(	'title' => 'Shipping',
									'save_name' => 'save_shipping',
									'success_message' => 'Settings changed',
									'fields' => array(
														array('name' => 'shipping_type', 'alias' => 'Shipping based on weight', 'type' => 'radio', 'value' => 0),
														array('name' => 'shipping_type', 'alias' => 'Fixed shipping', 'type' => 'radio', 'value' => 1),
														array('name' => 'shipping_type', 'alias' => 'Shipping based on items', 'type' => 'radio', 'value' => 2)
									)
							)
                            
						);
	
	function AdminSettings()
	{
		parent::Runmode();
				
	}
	
	function process()
	{
		$sm = new SettingsHolder();
		foreach ($this->settings as $section)
		{
			if ((isset($_REQUEST[$section['save_name']]) && !empty($_REQUEST[$section['save_name']])) || (isset($_REQUEST['save_all']) && !empty($_REQUEST['save_all'])))
			{
				$to_save = array();
				foreach ($section['fields'] as $field)
					$to_save[$field['name']] = $this->process_setting_field($_REQUEST,$field);			
				
				$sm->saveSettings($to_save);
			}
		}
		
		$new_settngs = $sm->loadSettings();
		foreach ($this->settings as $key => $section)
			foreach ($section['fields'] as $k => $field)
				if (isset($new_settngs[$field['name']])) 
				{
					if ($field['type'] == 'radio')
						$this->settings[$key]['fields'][$k]['db_value'] = $new_settngs[$field['name']];
					else $this->settings[$key]['fields'][$k]['value'] = $new_settngs[$field['name']];

					//$this->settings[$key]['fields'][$k]['value'] = $new_settngs[$field['name']];
				}

		$GLOBALS['core.smarty']->assign('setting_list',$this->settings);
		return Admin_Header::out('admin_settings');
	}
	
	function process_setting_field($request,$field)
	{
		$to_ret = '';
		if ($field['type'] == 'bool')
		{
			$to_ret = (isset($_REQUEST[$field['name']]) && !empty($_REQUEST[$field['name']])) ? 1 : 0;
		}
		elseif ($field['type'] == 'int')
		{
			$to_ret = (isset($_REQUEST[$field['name']]) && !empty($_REQUEST[$field['name']])) ? $_REQUEST[$field['name']] : 0;
		}
		elseif ($field['type'] == 'string')
		{
			$to_ret = (isset($_REQUEST[$field['name']]) && !empty($_REQUEST[$field['name']])) ? $_REQUEST[$field['name']] : '';
		}
		elseif ($field['type'] == 'radio')
		{
			$to_ret = (isset($_REQUEST[$field['name']]) && !empty($_REQUEST[$field['name']])) ? $_REQUEST[$field['name']] : 0;
		}
		return $to_ret;
	}
}


?>