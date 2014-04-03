<?php

namespace FMW\Utilities\Cache;

use FMW\Utilities\File\File;

/** 
 * 
 * Classe Cache
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class FileCache 
	extends ACache {
		
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $_path;
	
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $_ext;
	
	/**
	 * 
	 * Enter description here ...
	 * @var \FMW\Utilities\File\File
	 */
	private $_file;
			
	/**
	 * 
	 * Enter description here ...
	 * @param array $params
	 * @access public
	 * 
	 */
	public function __construct( array $params ) {			
	
		if ( ! isset( $params['path'] ) ) throw new Exception('Não foi possível gerar o cache!');

		$this->_ext = isset( $params['ext'] ) ?  $params['ext'] : 'txt';
		$this->_path = $params['path'] . DIRECTORY_SEPARATOR;
		
		$this->_file = new File();
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $id
	 */
    protected function _doContains($id) {
    	    	
    	$dir = opendir($this->_path); 
    	while (($file = readdir($dir)) !== false) {
    		if ($file != "." && $file != "..") { 
    			
		        if ( preg_match_all("/{$id}_([0-9]*)/", $file, $match) ) {
		        	
		        	$file = $this->_path . $match[0][0] . '.' . $this->_ext;
		        	$lifetime = $match[1][0];
		      		$this->set($id, $file);
		     
		        	if (time() - @filemtime( $file ) <= $lifetime) {
		        	
		        		closedir($dir);
		        		return true;	
		        	}
		        } 
		    } 
    	}
    	
    	closedir($dir);
    	return false;
    }
    
    /**
     * 
     * Enter description here ...
     * @param string $id
     */
    public function _doCacheTime($id) {
    	
    	/*if ( $this->_doContains($id) ) { 
    		
    		$stream = $this->_file
    					->open($this->$id, false)
    						->getContentCh();
    	 							
    		$this->_file->close();
    		
    		if ( preg_match_all("/<!-- Cached:(.*), expire in: (.*)-->/Ui", $stream, $matches) ) {
    			
    			return $matches[2][0];
    		}
    	}
    	
    	return false;*/
    }
    
    /**
     * 
     * Enter description here ...
     * @param string $id
     */
    public function _doFetch($id) {
    	
    	if (! isset($this->$id))
    		$this->_doContains($id); 
    	
    	$stream = $this->_file
    				->open($this->$id, false)
    	 				->getContentCh();
    	 							
    	$this->_file->close();
	    
	    return $stream;
    }
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $id
	 * @param string $value
	 * @param int $lifetime
	 */
	protected function _doSave( $id, $value, $lifetime ) {
		
		$file = $this->_path . $id . '_' . $lifetime . '.' . $this->_ext;
		
		if ($this->_ext == 'js' || $this->_ext == 'css') { 
			$time = PHP_EOL . '/*
								* Cataya CMS
								* Desenvolvido por Fabrik7
								* Cached: ' . date('Y-m-d h:i:s') . ', expire in: ' . date('Y-m-d h:i:s', strtotime("+{$lifetime} seconds")) . '
								*		 
							    */';
		} else {
			$time = PHP_EOL . ' <!-- 
									Cataya CMS
									Desenvolvido por Fabrik7
									Cached: ' . date('Y-m-d h:i:s') . ', expire in: ' . date('Y-m-d h:i:s', strtotime("+{$lifetime} seconds")) . '
								-->';
		}
				
		$this->_file
			->create($file, 'w+')
				->write($value)
					->write($time)
						->close();
		
		
        $this->set( $id, $file ); 
         
        return true;
	}
}