<?php
require_once('modules/CMS/MenuHolder.php');
require_once('modules/CMS/Menu.php');
require_once('classes/CMS/SettingsHolder.php');
require_once('classes/CategoryHolder.php');
require_once('classes/BrandHolder.php');
require_once('classes/UserHolder.php');
require_once('classes/ProductHolder.php');


class Common_Header
{
	function out($tpl = '', $template = '')
	{
		$menu_holder = new MenuHolder();
		list($html_menus, $home_page) = $menu_holder->getFrontEnd();
		
                $GLOBALS['core.smarty']->assign('html_menus',$html_menus);
                $GLOBALS['core.smarty']->assign('html_home_page', $home_page);

                //$ch = new CategoryHolder();
                //$cats = $ch->getCategoriesForHeader();
                //pp($cats);
                //$GLOBALS['core.smarty']->assign('categories',$cats);
                //$GLOBALS['core.smarty']->assign('top_categories', $ch->getTops());

                $bh = new BrandHolder();
		$brands = $bh->get_all();
		$GLOBALS['core.smarty']->assign('brands',$brands);

                //Рандомная фотка для блока галереи
                $photo = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#gallery_one_module_picture ORDER BY RAND() LIMIT 1');
                if (!empty($photo)) {
                    $GLOBALS['core.smarty']->assign('gallery_photo',$photo['pic1']);
                }

                if ($GLOBALS['core.auth.user']->uid)
                {
                        $GLOBALS['core.smarty']->assign('usr_logged_in',1);
                        if ($GLOBALS['core.auth.user']->is_member_of('user'))
                        {
                                $GLOBALS['core.smarty']->assign('logged_in',1);
                                $user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
                                $user_data = $user->getFullData();
                                //pp($user_data);
                                $GLOBALS['core.smarty']->assign('logged_user_data', $user_data);
                                //pp($_SESSION);
                                if (!isset($_SESSION['last_ordered']))
                                {
                                        $last_ordered = "";
                                        $payment = $GLOBALS['core.sql']->getRow("select * from #p#payment where user_id = ? order by created desc ", array($GLOBALS['core.auth.user']->uid));
                                        if (!empty($payment)) $last_ordered = unserialize($payment['cart_info']);
                                        $_SESSION['last_ordered'] = $last_ordered;
                                        //pp($payment);
                                }
                                $GLOBALS['core.smarty']->assign('last_ordered', $_SESSION['last_ordered']);
                                //pp($_SESSION['last_ordered']);

                                $prh = new ProductHolder();
                                $products = $prh->getAll();
                                $GLOBALS['core.smarty']->assign('all_products', $products);


                        }
                }

                $sh = new SettingsHolder();
                $settings = $sh->getSettings();
                $GLOBALS['core.smarty']->assign('settings',$settings);


                $menu = new Menu();

                $pages = $menu->get_all_pages();
                $pages_tree = $menu_holder->getPages();


                $GLOBALS['core.smarty']->assign('pages_tree',$pages_tree);

                $ph = new ProductHolder();
                $featured = $ph->getForFeaturedSection(1, 1);
                $GLOBALS['core.smarty']->assign('featured',array_slice($featured,0));

                $discount = $ph->getForDiscountSection(1, 1);
                $GLOBALS['core.smarty']->assign('discount',$discount);


                if (!empty($tpl)) {
                    $GLOBALS['core.smarty']->assign('body', $tpl . '.tpl');
                }
		
		if (empty($template)) {
                    return $GLOBALS['core.smarty']->fetch('common_header.tpl');
                }
		else {
                    return $GLOBALS['core.smarty']->fetch('./Headers/' . $template . '.tpl');
		}
	}
	
}
?>