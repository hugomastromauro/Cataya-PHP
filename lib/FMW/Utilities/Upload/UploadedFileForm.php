<?php

namespace FMW\Utilities\Upload;

/**
 *
 * Classe UploadedFileForm
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Upload
 * @subpackage Utilities
 *
 */
class UploadedFileForm {
	
	/**
	 * 
	 * @var array
	 */
	private $_file;
	
	/**
	 * 
	 * @var array
	 */
	private $_settings;
	
	/**
	 * 
	 * @param object $file
	 * @param array $settings
	 */
	public function __construct($file, $settings) {
		
		$this->_file = $file;
		$this->_settings = $settings;
	}
	
	/**
	 * 
	 * @param array $file
	 * @return boolean
	 */
	public function save($file) {
		if(!move_uploaded_file($this->_file['tmp_name'], $file)){
			return false;
		}
		return true;
	}
	
	/**
	 * 
	 * @return multitype:
	 */
	public function getName() {
		return $this->_file['name'];
	}
	
	/**
	 * 
	 * @return multitype:
	 */
	public function getTemp() {
		return $this->_file['tmp_name'];
	}
	
	/**
	 * 
	 * @return multitype:
	 */
	public function getSize() {
		return $this->_file['size'];
	}
}