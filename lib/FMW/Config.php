<?php

namespace FMW;

/** 
 * 
 * Classe Config
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Config 
	extends Object {
	
	/**
	 * 
	 * @param array $array
	 */
	public function __construct( array $array ) {			
		$this->_data = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->_data[$key] = new self($value);
            } else {
                $this->_data[$key] = $value;
            }
        }
        $this->_count = count($this->_data);			
	}

    /**
     * (non-PHPdoc)
     * @see FMW.Object::__set()
     */
	public function __set($name, $value) {
		
		if (is_array($value)) {
			$this->_data[$name] = new self($value);
		} else {
			$this->_data[$name] = $value;
		}
		$this->_count = count($this->_data);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW.Object::__clone()
	 */
    public function __clone()
    {
		$array = array();
		foreach ($this->_data as $key => $value) {
			if ($value instanceof \FMW\Config) {
				$array[$key] = clone $value;
			} else {
				$array[$key] = $value;
			}
		}
		$this->_data = $array;
    }
    
    /**
     * 
     * @param string $name
     */
    public function remove( $name ) {
    	
    	unset($this->_data[$name]);
    	$this->_count = count($this->_data);
    }
    
    /**
     * (non-PHPdoc)
     * @see FMW.Object::setArray()
     */
    public function setArray( array $array ) {
    	
    	foreach ($array as $key => $value) {
    		if (is_array($value)) {
    			$this->_data[$key] = new self($value);
    		} else {
    			$this->_data[$key] = $value;
    		}
    	}
    	$this->_count = count($this->_data);
    }

    /**
     * (non-PHPdoc)
     * @see FMW.Object::toArray()
     */
    public function toArray()
    {
        $array = array();
        $data = $this->_data;
        foreach ($data as $key => $value) {
            if ($value instanceof \FMW\Config) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }
}