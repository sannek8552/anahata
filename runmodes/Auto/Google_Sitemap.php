<?php
//require_once('modules/Common_Menu.php');
require_once('classes/ProductHolder.php');
//require_once('classes/CategoryHolder.php');

class Google_Sitemap
{
	function process()
	{
		header('Content-Type:text/xml');
		print '<?xml version="1.0" encoding="UTF-8"?>';
  		print '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                               xmlns:image="http://www.sitemaps.org/schemas/sitemap-image/1.1">';
		//here we need to get all active item in menu
		$menus = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#menu WHERE active=1');
		
		do
		{
			$count = 0;
			foreach ($menus as $key => $value)
			{
				if((int)$value['parent_id'] != 0)
				{
					$flag = 0;
					foreach ($menus as $val)
					{
						if($value['parent_id'] == $val['id'])
						{
							$flag = 1;
						}
					}
					if($flag != 1)
					{
						unset($menus[$key]);
						$count++;
					}
				}
			}
		} while ($count > 0);
		$t_conf = $GLOBALS['core.config']->get_config('templates');
		foreach ($menus as $key => $value)
		{
			$freq = 'yearly';
			if(time() - $value['updated'] <= 2592000)
			{
				$freq = 'monthly';
			}
			if(time() - $value['updated'] <= 604800)
			{
				$freq = 'weekly';
			}
			if(time() - $value['updated'] <= 86400)
			{
				$freq = 'daily';
			}
			if(time() - $value['updated'] <= 3600)
			{
				$freq = 'hourly';
			}
			//for now assume all menus are static
			print '<url>';
			print '<loc>' . $t_conf['common']['domain_name'] . $t_conf['common']['script_url'] . $value['seo_url'] . '.html' . '</loc>';
                        if ($value['seo_url'] == 'index') {
                        print '<image:image>
                                   <image:loc>'.$t_conf['common']['domain_name'] . $t_conf['common']['img_url'].'logo.png</image:loc>
                                   <image:title>Логотип Анахата</image:title>
                               </image:image>';
                        }
			print '<lastmod>' . date("Y-m-d",$value['updated']) . '</lastmod>';
			print '<priority>' . $value['google_priority'] . '</priority>';
			print '<changefreq>' . $freq . '</changefreq>';
			print '</url>';			
		}
		
		/*$ph = new ProductHolder();
		$products = $ph->getAllActive();
		foreach ($products as $key => $value)
		{
			$freq = 'yearly';
			if(time() - $value['updated'] <= 2592000)
			{
				$freq = 'monthly';
			}
			if(time() - $value['updated'] <= 604800)
			{
				$freq = 'weekly';
			}
			if(time() - $value['updated'] <= 86400)
			{
				$freq = 'daily';
			}
			if(time() - $value['updated'] <= 3600)
			{
				$freq = 'hourly';
			}
			//for now assume all menus are static
			print '<url>';
			print '<loc>' . $t_conf['common']['domain_name'] . $t_conf['common']['script_url'] .'Product/'. $value['seo'] . '.html' . '</loc>';
			print '<lastmod>' . date("Y-m-d",$value['updated']) . '</lastmod>';
			print '<priority>0.1</priority>';
			print '<changefreq>' . $freq . '</changefreq>';
			print '</url>';
		}
		$ch = new CategoryHolder();
		$categories = $ch->getAllForGoogleSitemap();
		foreach ($categories as $key => $value)
		{
			$freq = 'yearly';
			if(time() - $value['updated'] <= 2592000)
			{
				$freq = 'monthly';
			}
			if(time() - $value['updated'] <= 604800)
			{
				$freq = 'weekly';
			}
			if(time() - $value['updated'] <= 86400)
			{
				$freq = 'daily';
			}
			if(time() - $value['updated'] <= 3600)
			{
				$freq = 'hourly';
			}
			//for now assume all menus are static
			print '<url>';
			print '<loc>' . $t_conf['common']['domain_name'] . $t_conf['common']['script_url'] .'Category/'. $value['seo_url'] . '.html' . '</loc>';
			print '<lastmod>' . date("Y-m-d",$value['updated']) . '</lastmod>';
			print '<priority>0.1</priority>';
			print '<changefreq>' . $freq . '</changefreq>';
			print '</url>';
		}*/
		
		print '</urlset>';
		return '';
	}
}
?>