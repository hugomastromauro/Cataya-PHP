<?php

namespace FMW\Utilities\Image;

/**
 *
 * Class Image
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, hugomastromauro.com.
 * @access public
 * @package FMW
 * @subpackage lib
 *
 */
class Image {
	
	/**
	 * 
	 */
	public function __construct() {
		
		ini_set('memory_limit', '64M');
	}
	
	/**
	 * 
	 * @param array $src
	 */
	public function getSize($src) {
		return getimagesize($src);
	}
	
	/**
	 *
	 * @param mixed $image
	 * @param int $newwidth
	 */
	public function proportion($image, $newwidth) {
	
		$src = imagecreatefromjpeg($image);
	
		list($width, $height) = getimagesize($image);
	
		if ($width < $newwidth)
			$newwidth = $width;
	
		return ($height/$width) * $newwidth;
	}
	
	/**
	 *
	 * @param string $src
	 * @param string $dest
	 * @param int $new_width
	 * @param int $new_height
	 * @param int $quality
	 * @param int $border
	 */
	public function resize($src, $dest, $new_width, $new_height, $quality, $border, $crop = false) {
	
		$width  = 0;
		$height = 0;
			
		list($width, $height) = getimagesize($src);
		
		if ($width < $new_width)
			$new_width = $width;
		
		$new_width = $new_width + ( 2 * $border );
		$new_height = $new_height + ( 2 * $border );
		
		$newImage = imagecreatetruecolor($new_width, $new_height);
		
		if ($crop) {
			
			$width_temp = $new_width;
			$height_temp = $new_height;
		
			if ($width/$height > $new_width/$new_height){
				$new_width = $width*$new_height/$height;
				$x_pos = -($new_width-$width_temp)/2;
				$y_pos = 0;
			}else{
				$new_height = $height*$new_width/$width;
				$y_pos = -($new_height-$height_temp)/2;
				$x_pos = 0;
			}
		} 
	
		if ($border > 0) {
			$border_color = imagecolorallocate($newImage, 255, 255, 255);
			imagefilledrectangle($newImage, 0, 0, $new_width, $new_height, $border_color);
		}
	
		$oldImage = $this->createFromFile($src);
		
		if ($crop) {
			$this->fastimagecopyresampled($newImage, $oldImage, $x_pos, $y_pos, 0, 0, $new_width, $new_height, $width, $height, $quality);
		} else {
			$this->fastimagecopyresampled($newImage, $oldImage, 0, 0, 0, 0, $new_width, $new_height, $width, $height, $quality);
		}
		
		imagejpeg($newImage, $dest, 100);
	}
	
	/**
	 *
	 * @param string $path
	 * @param bool $user_functions
	 */
	public function createFromFile($path, $user_functions = false) {
	
		$info = @getimagesize($path);
	
		if(!$info) return false;
	
		$functions = array(
			IMAGETYPE_GIF => 'imagecreatefromgif',
			IMAGETYPE_JPEG => 'imagecreatefromjpeg',
			IMAGETYPE_PNG => 'imagecreatefrompng',
			IMAGETYPE_WBMP => 'imagecreatefromwbmp',
			IMAGETYPE_XBM => 'imagecreatefromwxbm'
		);
	
		if($user_functions)
			$functions[IMAGETYPE_BMP] = 'imagecreatefrombmp';
	
		if(!$functions[$info[2]]) return false;
	
		if(!function_exists($functions[$info[2]])) return false;
	
		return $functions[$info[2]]($path);
	}
	
	/**
	 *
	 * @param string $dst_image
	 * @param string $src_image
	 * @param int $dst_x
	 * @param int $dst_y
	 * @param int $src_x
	 * @param int $src_y
	 * @param int $dst_w
	 * @param int $dst_h
	 * @param int $src_w
	 * @param int $src_h
	 * @param int $quality
	 * @return boolean
	 */
	private function fastimagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3) {
	
		if (empty($src_image) || empty($dst_image)) return false;
	
		if ($quality <= 1) {
	
			$temp = imagecreatetruecolor ($dst_w + 1, $dst_h + 1);
	
			imagecopyresized ($temp, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w + 1, $dst_h + 1, $src_w, $src_h);
			imagecopyresized ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);
			imagedestroy($temp);
	
		} elseif ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
	
			$tmp_w = $dst_w * $quality;
			$tmp_h = $dst_h * $quality;
	
			$temp = imagecreatetruecolor ($tmp_w + 1, $tmp_h + 1);
	
			imagecopyresized ($temp, $src_image, $dst_x * $quality, $dst_y * $quality, $src_x, $src_y, $tmp_w + 1, $tmp_h + 1, $src_w, $src_h);
			imagecopyresampled ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $tmp_w, $tmp_h);
			imagedestroy($temp);
	
		} else {
				
			imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		}

		return true;
	}
}