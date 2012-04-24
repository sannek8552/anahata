<?php
	/*
		Usage:
		-----------------------------------------------------------------------------
		Create thumbnail with fixed width and height without crop. Empty area fills with specified(optional) color, default is black.
		$GLOBALS['core.image']->create_thumb($source_path,$dest_path,$width,$height);
		-----------------------------------------------------------------------------
		Create thumbnail with fixed width and height with crop. Image resized for fit one of dimensions and then crops on other dimension.
		$GLOBALS['core.image']->create_thumb_crop($source_path,$dest_path,$width,$height)		
		-----------------------------------------------------------------------------
		Create thumbnail with fixed width. Image resized to fit specified width.
		$GLOBALS['core.image']->create_thumb_width($source_path,$dest_path,$width)
	*/


	class Image extends Module
	{
		var $types = array('gif' => 1, 'jpg' => 2, 'jpeg' => 2, 'png' => 3);
		function Image($cfg)
		{
			
		}

		function init()
		{
		}
		
		function run()
		{
		}
		
		
		
		function create_thumb($source_path,$dest_path,$width,$height,$type=null,$color=0xffffff,$direct = false)
		{	
			$GLOBALS['core.log']->do_log("Image: create_thumb source=$source_path dest=$dest_path width=$width height=$height",'core');
		  if (empty($source_path)) return PEAR::Error();
		  list($width_orig, $height_orig, $type) = getimagesize($source_path);
		  
		  $width_out = $width;
		  $height_out = $height;
		  
		  $qw = $width/$width_orig;
		  $qh = $height/$height_orig;		
		  
		  if ($qh<$qw)
		  {
		    $width = ($height / $height_orig) * $width_orig;
		  }
		  else
		  {
		    $height = ($width / $width_orig) * $height_orig;
		  }
		  
		  
          if ($type == 2)
		  {
		    return $this->image_jpg($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct);
		  }
		  elseif ($type == 1)
		  {
		    return $this->image_gif($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct);
		  }
		  elseif ($type == 3)
		  {
		    return $this->image_png($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct);
		  }
		}
		
		function create_thumb_width($source_path,$dest_path,$width,$type=null,$color=0x000000,$direct = false)
		{
			$GLOBALS['core.log']->do_log("Image: create_thumb_width source=$source_path dest=$dest_path width=$width",'core');
			if (empty($source_path)) return PEAR::Error();
			$result = @getimagesize($source_path);
			if (!$result) return $result;
			list($width_orig, $height_orig, $type) = $result;

			#var_dump($width_orig);
			#var_dump($width);
			if ($width_orig < $width) $width = $width_orig;
			#var_dump($width);
			
			$width_out = $width;						
			$height = ($width / $width_orig) * $height_orig;
			$height_out = $height;
			#var_dump($width_out);
			#var_dump($height_out);
			if ($type == 2)
			{
			  return $this->image_jpg($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct);
			}
			elseif ($type == 1)
			{
			  return $this->image_gif($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct);
			}
			elseif ($type == 3)
			{
			  return $this->image_png($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct);
			}
		}
		
		function image_jpg($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct = false)
		{
		  $image_p = imagecreatetruecolor($width, $height);
		  $image = imagecreatefromjpeg($source_path);
		  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

		  list($copy_x,$copy_y) = $this->__get_copy_coords($width,$height,$width_out,$height_out);
		  $image_b = imagecreatetruecolor($width_out, $height_out);
		  imagefill($image_b,0,0,$color);
		  imagecopy($image_b,$image_p,$copy_x,$copy_y,0,0,$width,$height);
		  if ($direct) return $image_b;
		  else imagejpeg($image_b, $dest_path, 100);
		}
		
		function image_gif($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct = false)
		{
		  $image_p = imagecreatetruecolor($width, $height);
		  $image = imagecreatefromgif($source_path);
		  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		    
		  list($copy_x,$copy_y) = $this->__get_copy_coords($width,$height,$width_out,$height_out);
		  $image_b = imagecreatetruecolor($width_out, $height_out);
		  imagefill($image_b,0,0,$color);
		  imagecopy($image_b,$image_p,$copy_x,$copy_y,0,0,$width,$height);
		  if ($direct) return $image_b;
		  else imagejpeg($image_b, $dest_path, 100);
		}
		
		function image_png($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$color,$type,$direct = false)
		{
		  $image_p = imagecreatetruecolor($width, $height);
		  $image = imagecreatefrompng($source_path);
		  
		  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		  list($copy_x,$copy_y) = $this->__get_copy_coords($width,$height,$width_out,$height_out);
		  $image_b = imagecreatetruecolor($width_out, $height_out);
		  imagefill($image_b,0,0,$color);
		  
		  
		  
		  imagecopy($image_b,$image_p,$copy_x,$copy_y,0,0,$width,$height);
		  if ($direct) return $image_b;
		  else imagejpeg($image_b, $dest_path, 100);
		  
		}
		
		function __get_copy_coords($width,$height,$width_out,$height_out)
		{
		  $copy_x = 0;
		  $copy_y = 0;
		  
		  if ($width<$width_out)
		  {
		    $copy_x = ($width_out - $width)/2;
		  }
		  
		  if ($height<$height_out)
		  {
		    $copy_y = ($height_out - $height)/2;
		  }
		  
		  #var_dump($copy_x);
		  #var_dump($copy_y);
			/*
		  if ($width > $height) {
		    $size = $width;		    
		    $copy_x = 0;
		    $copy_y = ($width-$height)/2;
		  }
		  else
		  {
		    $size = $height;
		    $copy_y = 0;
		    $copy_x = ($height-$width)/2;
		  }
			*/
		  return array($copy_x,$copy_y);
		}
		
		function create_thumb_crop($source_path,$dest_path,$width,$height,$type=null,$direct = false)
		{
			$GLOBALS['core.log']->do_log("Image: create_thumb_crop source=$source_path dest=$dest_path width=$width height=$height",'core');
			if (empty($source_path)) return PEAR::Error();
			$result = @getimagesize($source_path);
			if (!$result) return $result;
			list($width_orig, $height_orig, $type) = $result;			
			
			
			$width_out = $width;
			$height_out = $height;
			
			$qw = $width/$width_orig;
			$qh = $height/$height_orig;	
			
			if ($qh > $qw)
			{
			  $width = ($height / $height_orig) * $width_orig;
			}
			else
			{
			  $height = ($width / $width_orig) * $height_orig;
			}
			
			if ($type == 2)
			{				
				return $this->image_jpg_crop($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$type,$direct);				
			}
			elseif ($type == 1)
			{
				return $this->image_gif_crop($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$type,$direct);
			}
			elseif ($type == 3)
			{
				return $this->image_png_crop($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$type,$direct);
			}
		}
		
		function image_jpg_crop($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$type,$direct = false)
		{
			$image_p = imagecreatetruecolor($width, $height);//image with calculated sizes
			$image = @imagecreatefromjpeg($source_path);//source image
			#var_dump($image);
			if (!$image) return $image;
			#print 'here';
      
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);//resize image
      
			list($copy_x,$copy_y) = $this->__get_copy_coords_crop($width,$height,$width_out,$height_out);
			$image_b = imagecreatetruecolor($width_out, $height_out);//image with needed sizes		  
			imagecopy($image_b,$image_p,0,0,$copy_x,$copy_y,$width_out,$height_out);
			if ($direct) return $image_b;
		  	else return imagejpeg($image_b, $dest_path, 100);
		}
		
		function image_gif_crop($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$type,$direct = false)
		{
			$image_p = imagecreatetruecolor($width, $height);//image with calculated sizes
			$image = @imagecreatefromgif($source_path);//source image
			if (!$image) return $image;
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);//resize image
      
			list($copy_x,$copy_y) = $this->__get_copy_coords_crop($width,$height,$width_out,$height_out);
			$image_b = imagecreatetruecolor($width_out, $height_out);//image with needed sizes		  
			imagecopy($image_b,$image_p,0,0,$copy_x,$copy_y,$width_out,$height_out);
			if ($direct) return $image_b;
		  	else return imagejpeg($image_b, $dest_path, 100);
		}
		
		function image_png_crop($source_path,$dest_path,$width,$height,$width_orig,$height_orig,$width_out,$height_out,$type,$direct = false)
		{
			$image_p = imagecreatetruecolor($width, $height);//image with calculated sizes
			$image = @imagecreatefrompng($source_path);//source image
			if (!$image) return $image;
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);//resize image
      
			list($copy_x,$copy_y) = $this->__get_copy_coords_crop($width,$height,$width_out,$height_out);
			$image_b = imagecreatetruecolor($width_out, $height_out);//image with needed sizes		  
			imagecopy($image_b,$image_p,0,0,$copy_x,$copy_y,$width_out,$height_out);
			if ($direct) return $image_b;
		  	else return imagejpeg($image_b, $dest_path, 100);
		}
		
		function __get_copy_coords_crop($width,$height,$width_out,$height_out)
		{
		  $copy_x = 0;
		  $copy_y = 0;
		  
		  if ($width > $width_out)
		  {
		    $copy_x = ($width - $width_out)/2;
		  }
		  
		  if ($height > $height_out)
		  {
		    $copy_y = ($height - $height_out)/2;
		  }

		  return array($copy_x,$copy_y);
		}
	}
?>