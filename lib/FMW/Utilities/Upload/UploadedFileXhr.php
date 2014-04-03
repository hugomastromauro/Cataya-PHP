<?php

namespace FMW\Utilities\Upload;

/**
 *
 * Class UploadedFileXhr
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, hugomastromauro.com.
 * @access public
 * @package FMW
 * @subpackage lib
 *
 */
class UploadedFileXhr {
	
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
	 * @return object
	 */
	public function getName() {
		return $this->file;
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