<?php
require_once('Data_Holder.php');
require_once('SettingsHolder.php');

class CouponHolder extends Data_Holder_Simple 
{
	function CouponHolder($id = null)
	{		
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('coupon',$key_info);
	}
	
	function getAll()
	{
		return $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." order by name ",array(),'id');
	}
	
	function loadByCode($code)
	{
		$id = $GLOBALS['core.sql']->getOne("select id from #p#".$this->table." where code = ?",array($code));
		if (!empty($id))
		{
			$this->load($id);
			return true;
		}
		return false;
	}
	
	function processCart($cart, $update = null)
	{		
		$id = $this->get_key_value();
		$to_ret = array('discount' => 0,'error_message' => '');
		//foreach ()
		if (!empty($id))
		{
			$ch = new CartManager();
			$ch->calculate_total($cart);
		
			$data = $this->get_data();
			$c_array = array();
			if(isset($_SESSION['coupons']))
			{	
				foreach ($_SESSION['coupons'] as $k => $val)
				{
					$c_array[] = $k;
				}
			}
			if(!in_array($data['id'], $c_array) || !is_null($update))
			{
				if($data['start_date'] < time() && time() < mktime(23,59,59, date("m", $data['end_date']), date("d", $data['end_date']), date("Y", $data['end_date'])))
				{
					if ($data['count_of_uses'] < $data['uses_per_coupon'])
					{
						$user_uses = CouponHolder::count_of_user_uses($GLOBALS['core.auth.user']->uid, $data['id']);
						if($data['uses_per_customer'] > $user_uses)
						{
							if ($_SESSION['total_cost'] >= $data['minimum_order'])
					    	{
					    		$sh = new SettingsHolder();
					    		$settings = $sh->loadSettings();
					    		$uses = 0;
					    		$uses_pc = 0;
					    		
					    		if ($data['apply_type'] == 'everything')
									{
										if ($data['type'] == 'amount')
										{
										    $to_ret['discount'] = $data['amount'];
										}
										elseif ($data['type'] == 'percent')
										{
										    $to_ret['discount'] = round($_SESSION['total_cost'] * $data['amount']/100,2);
										}
									}
								else
								{					    		
									foreach ($cart as $key => $value)
									{
										if ($data['apply_type'] == 'category')
										{
											if($data['item_id'] == $value['category_id'] && $uses < $settings['coupon_category'])
											{
												if ($data['type'] == 'amount')
												{
													if($settings['coupon_category'] - $uses > $value['quantity'])
													{
												    	$to_ret['discount'] += $data['amount'] * $value['quantity'];
												    	$uses += $value['quantity'];
													}
													else 
													{
														$to_ret['discount'] += $data['amount'] * ($settings['coupon_category'] - $uses);
														$uses += $settings['coupon_category'] - $uses;
													}
												}
												elseif ($data['type'] == 'percent')
												{
													if($settings['coupon_category'] - $uses > $value['quantity'])
													{
												    	$to_ret['discount'] += round($value['price'] * $value['quantity'] * $data['amount']/100,2);
												    	$uses += $value['quantity'];
													}
													else 
													{
												    	$to_ret['discount'] += round($value['price'] * ($settings['coupon_category'] - $uses) * $data['amount']/100,2);
												    	$uses += $settings['coupon_category'] - $uses;
													}
												}
											}
											
										}
										elseif ($data['apply_type'] == 'product')
										{
											if($data['item_id'] == $value['product_id'] && $uses_pc < $settings['coupon_product'])
											{
												if ($data['type'] == 'amount')
												{
													if($settings['coupon_product'] - $uses_pc > $value['quantity'])
													{
												    	$to_ret['discount'] += $data['amount'] * $value['quantity'];
												    	$uses_pc += $value['quantity'];
													}
													else 
													{
														$to_ret['discount'] += $data['amount'] * ($settings['coupon_product'] - $uses_pc);
														$uses_pc += $settings['coupon_product'] - $uses_pc;
													}
												}
												elseif ($data['type'] == 'percent')
												{
													if($settings['coupon_product'] - $uses_pc > $value['quantity'])
													{
												    	$to_ret['discount'] += round($value['price'] * $data['amount'] * $value['quantity'] / 100,2);
												    	$uses_pc += $value['quantity'];
													}
													else 
													{
														$to_ret['discount'] += round($value['price'] * $data['amount'] * ($settings['coupon_product'] - $uses_pc) / 100,2);
														$uses_pc += $settings['coupon_product'] - $uses_pc;
													}
												}
											}
										}
									}
								}
					    	}
					    	else 
					    	{
					    		$to_ret['error_message'] = 'Not enough order total to use this coupon';
					    	}
						}
						else 
						{
							$to_ret['error_message'] = 'You can\'t use this coupon again.';
						}
					}
					else 
					{
						$to_ret['error_message'] = 'This coupon can\'t be used more.';
					}
				}
				else 
				{
					$to_ret['error_message'] = 'Coupon is out of date';
				}
			}
			else 
			{
				$to_ret['error_message'] = 'This coupon aready used';
			}
		}
		return $to_ret;
	}
	
	function count_of_user_uses($user_id, $coupon_id)
	{
		return $GLOBALS['core.sql']->getOne('SELECT count_uses FROM #p#coupon_user_uses WHERE user_id = ? AND coupon_id =?', array($user_id, $coupon_id));
	}
	function save_user_coupon($user_id, $coupon_id)
	{
		$arr = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#coupon_user_uses WHERE user_id = ? AND coupon_id =?', array($user_id, $coupon_id));
		if(count($arr) > 0)	$GLOBALS['core.store']->save('coupon_user_uses', array('count_uses' => $arr['count_uses'] + 1), array('key_name' => 'id', 'key_value' => $arr['id']));
		else $GLOBALS['core.store']->save('coupon_user_uses', array('count_uses' => 1, 'user_id' => $user_id, 'coupon_id' => $coupon_id), array('key_name' => 'id'));
	}
	
}

?>