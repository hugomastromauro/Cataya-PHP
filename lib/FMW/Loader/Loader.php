<?php

namespace FMW\Loader;

use ReflectionClass;

/** 
 * 
 * Classe Loader
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Loader 
 * @subpackage FMW
 *  
 */ 
class Loader {
	
	/**
	 * 
	 * @var string
	 */
	protected static $_instance;
	
	/**
	 * 
	 * @var array
	 */
	protected $_class = array();
       	
	/**
	 * 
	 * @return string
	 */
	public static function getInstance() {
		
		if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
	}	
	
	/**
	 * 
	 * @param string $class
	 * @param array $params
	 * @return multitype:
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
	 * 
	 * @param string $class
	 * @return multitype:
	 */
	public function getClass( $class ) {
		
		return $this->_class [$class];
	}
}
