<?php

namespace FMW\Utilities\Upload;

/**
 *
 * Class UploadedFileForm
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, hugomastromauro.com.
 * @access public
 * @package FMW
 * @subpackage lib
 *
 */
class UploadedFileForm {
	
	/**
	 * 
	 * @var object
	 */
	private $file;
	
	/**
	 * 
	 * @var array
	 */
	private $settings;
	
	/**
	 * 
	 * @param object $file
	 * @param array $settings
	 */
	public function __construct($file, $settings) {
		
		$this->file = $file;
		$this->settings = $settings;
	}
	
	/**
	 * 
	 * @param string $path
	 */
	public function save($file) {
		if(!move_uploaded_file($this->file['tmp_name'], $file)){
			return false;
		}
		return true;
	}
	
	/**
	 * 
	 */
	public function getName() {
		return $this->file['name'];
	}
	
	/**
	 *
	 */
	public function getTemp() {
		return $this->file['tmp_name'];
	}
	
	/**
	 * 
	 */
	public function getSize() {
		return $this->file['size'];
	}
}