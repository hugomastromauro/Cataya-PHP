<?php

namespace FMW\Utilities\File;

use FMW\Utilities\File\Util;

/** 
 * 
 * Class Util
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class File 
	extends \FMW\Object {	
	
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $_file;
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $filename
	 * @throws Exception
	 */
	public function open( $filename, $create = false ) {
		
		$create = $create ? 'w+': 'r+';
		
		if ( ! $file = fopen( $filename, $create ) ) 
			throw new Exception ( "Não foi possível abrir o arquivo: {$filename}" );
			
		$this->_file = $file;
		
		return $this;
	}	
	
	/**
	 * 
	 * Enter description here ...
	 * @param bool $filename
	 */
	public function exists( $filename ) {
		
		if ( file_exists( $filename ) )
			return true;
			
		return false;	
	}

	/**
	 * 
	 * Enter description here ...
	 * @param string $filename
	 * @param string $permission
	 */
	public function create( $filename, $permission = 'w+' ) {
		
		if (! $file = fopen( $filename, $permission ) ) 
			throw new Exception ( "Não foi possível abrir o arquivo: {$filename}" );
			
		$this->_file = $file;
		
		return $this;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $stream
	 */
	public function writeCh( $stream ) {

		for ($written = 0; $written < strlen($stream); $written += $fwrite) {
	        $fwrite = fwrite($this->_file, substr($stream, $written));
	        if ($fwrite === false) {
	            return $written;
	        }
	    }
	    return $written;
	}
	
	/**
	 *
	 */
	public function createDirectory($dir) {
	
		if (!$this->exists($dir)) {
			if (!mkdir($dir, 0777, true)){
				throw new Exception('Impossível criar pasta no destino: ' . $dir . '!');
			}
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function getContent() {
		
		$stream = ''; 		
		while (($buffer = fgets($this->_file, 4096)) !== false) {
	        $stream .= $buffer;
	    }
	    return $stream;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param mixed $permission
	 */
	public function changePermission( $permission ) {
		chmod( $this->_file, $permission );
	}
	
	/**
	 * 
	 * @param unknown_type $dir
	 */
	public function rmdir($dir) {
		
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
				$this->rmdir($file);
			else
				unlink($file);
		}
		rmdir($dir);
		
		return true;
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function permission() {
		
		return fileperms($this->_file);
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public static function getDocumentRoot() {
		
		return realpath('.') . '/';
	}
	
	/**
	 * 
	 * @param string $module
	 */
	public static function getDocumentAsset( $module ) {

		return self::getDocumentRoot() . 'public/' . Util::removeslash($module) . '/assets/';
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function close() {
		fclose($this->_file);
	}
}