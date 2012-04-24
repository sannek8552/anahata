<?php
require_once('classes/ProductHolder.php');
require_once('classes/CMS/SettingsHolder.php');

class ShowImage extends Runmode 
{
	function ShowImage()
	{
		$this->base_map[0] = 'id';
		$this->base_map[1] = 'width';
		$this->base_map[2] = 'height';
		
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			$product = new ProductHolder($_REQUEST['id']);
			$data = $product->get_data();
			if (!empty($data))
			{
				$picture = $data['picture'];
				if (!empty($picture))
				{
					$conf = $GLOBALS['core.config']->get_config('templates');
					if (isset($conf['common']['picture_script_url']))
					{
						$sh = new SettingsHolder();
						$settings = $sh->getSettings();
						if (isset($_REQUEST['width']) && isset($_REQUEST['height'])
							&& isset($settings[$_REQUEST['width']]) && isset($settings[$_REQUEST['height']]))
							{
								$this->resize_and_download($settings[$_REQUEST['width']], $settings[$_REQUEST['height']],null,0xffffff,false,$picture);
							}
					}
				}
			}
		}
	}
	
	function resize_and_download($width = 0,$height = 0,$type=null,$color=0x000000,$crop = false, $file_name)
	{
		$GLOBALS['core.application']->init_module('gd_module',true);
		$templates = $GLOBALS['core.config']->get_config('templates');
		$path = $templates['common']['picture_script_url'] . $file_name;		
		$image = '';
		if (!empty($width))
		{
			if (!empty($height))
			{
				if ($crop)
				{
					$image = $GLOBALS['core.image']->create_thumb_crop($path,'',$width,$height,$type,true);
				}
				else 
				{
					$image = $GLOBALS['core.image']->create_thumb($path,'',$width,$height,$type,$color,true);
				}
			}
			else 
			{			
				$image = $GLOBALS['core.image']->create_thumb_width($path,'',$width,$type,$color,true);			
			}
		}
		
		if (!empty($image))
		{
			//header('Content-type: ' . $this->content_type);
			//header('Content-Disposition: attachment; filename="'. $this->real_name .'"');
			
			imagejpeg($image);
			// Free up memory
			imagedestroy($image);
		}
	}
}
?>