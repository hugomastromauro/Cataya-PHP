<?php

namespace FMW\Utilities\File;

use FMW\Utilities\File\Util;

/** 
 * 
 * Classe File
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package File 
 * @subpackage Utilities
 *  
 */ 
class File 
	extends \FMW\Object {	
	
	/**
	 * 
	 * @var resource
	 */
	private $_file;
	
	/**
	 * 
	 * @param string $filename
	 * @param string $create
	 * @throws Exception
	 * @return \FMW\Utilities\File\File
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
	 * @param string $filename
	 * @return boolean
	 */
	public function exists( $filename ) {
		
		if ( file_exists( $filename ) )
			return true;
			
		return false;	
	}

	/**
	 * 
	 * @param string $filename
	 * @param string $permission
	 * @throws Exception
	 * @return \FMW\Utilities\File\File
	 */
	public function create( $filename, $permission = 'w+' ) {
		
		if (! $file = fopen( $filename, $permission ) ) 
			throw new Exception ( "Não foi possível abrir o arquivo: {$filename}" );
			
		$this->_file = $file;
		
		return $this;
	}
	
	/**
	 * 
	 * @param resource $stream
	 * @return resource
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
	 * @param string $dir
	 * @throws Exception
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
	 * @return string
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
	 * @param string $permission
	 */
	public function changePermission( $permission ) {
		chmod( $this->_file, $permission );
	}
	
	/**
	 * 
	 * @param string $dir
	 * @return boolean
	 */
	public function rmdir( $dir ) {
		
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
	 * @return number
	 */
	public function permission() {
		
		return fileperms( $this->_file );
	}
	
	/**
	 * 
	 * @return string
	 */
	public static function getDocumentRoot() {
		
		return realpath('.') . '/';
	}
	
	/**
	 * 
	 * @param string $module
	 * @return string
	 */
	public static function getDocumentAsset( $module ) {

		return self::getDocumentRoot() . 'public/' . Util::removeslash($module) . '/assets/';
	}
	
	/**
	 * 
	 */
	public function close() {
		fclose($this->_file);
	}
}