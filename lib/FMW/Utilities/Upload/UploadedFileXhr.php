<?php

namespace FMW\Utilities\Upload;

/**
 *
 * Classe UploadedFileXhr
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Upload
 * @subpackage Utilities
 *
 */
class UploadedFileXhr {
	
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
	 * @param array $file
	 * @param array $settings
	 */
	public function __construct($file, $settings) {
	
		$this->_file = $file;
		$this->_settings = $settings;
	}	
	
	/**
	 * 
	 * @param string $path
	 * @return boolean
	 */
	public function save($path) {
		
		$input = fopen('php://input', 'r');
		$temp = tmpfile();

		$realSize = stream_copy_to_stream($input, $temp);
		fclose($input);

		if ($realSize != $this->getSize()){
			return false;
		}
		
		$target = fopen($path, 'w');
		fseek($temp, 0, SEEK_SET);
		stream_copy_to_stream($temp, $target);
		fclose($target);
		
		return true;
	}
	
	/**
	 * 
	 * @return multitype:
	 */
	public function getName() {
		return $this->_file;
	}
	
	/**
	 * 
	 * @return boolean|string
	 */
	public function getTemp() {

		if (false === ($temp = tempnam(sys_get_temp_dir(), uniqid('mgis')))) {
			return false;
        }
     	
        if (false === ($in = fopen('php://input', 'r')) || false === ($out = fopen($temp, 'w'))) {
			unlink($temp);
			return false;
        }

        stream_copy_to_stream($in, $out);
        fclose($in); fclose($out);

        return $temp;
	}
	
	/**
	 * 
	 * @throws Exception
	 * @return number
	 */
	public function getSize() {

		if (isset($_SERVER["CONTENT_LENGTH"])){
			return (int)$_SERVER["CONTENT_LENGTH"];
		} else {
			throw new Exception('Getting content length is not supported.');
		}
	}
}