<?php

namespace FMW\Loader;

use ReflectionClass;

/** 
 * 
 * Classe Loader
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Loader {
	
	/**
	 * 
	 * Enter description here ...
	 * @var FMW\Loader
	 */
	protected static $_instance;
	
	/**
	 * 
	 * Enter description here ...
	 * @var object
	 */
	protected $_class = array ();
       	
	/** 
     * Método Singleton
     * 
     * @static
     * @access public     
     * @return object 
     */
	public static function getInstance() {
		
		if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
	}	
	
	/** 
     * Método para carregar e instânciar classes
     * 
     * @access public
     * @param string $class
     * @param array $params     
     * @return void 
     */
	public function loadClass( $class, $params = array() ) {				
		
		if ( class_exists ( $class ) ) 
		{
			if ( ! isset($this ->_class [$class]) )
			{				
				$instObj = new ReflectionClass( $class );			
					
				if ( !empty( $params ) ) 
				{								
					$this ->_class [$class] = $instObj ->newInstanceArgs((array) $params);									
				}
				else
				{													
					$this ->_class [$class] = $instObj ->newInstance();
				}
				
				return $this->_class [$class];
				unset($instObj);
				
			} else {
								
				return $this->_class [$class];				
			}	
		}
	}
	
	/** 
     * Método que retorna classes carregadas
     * 
     * @access public
     * @param string $className     
     * @return object 
     */
	public function getClass( $class ) {
		
		return $this->_class [$class];
	}
}
