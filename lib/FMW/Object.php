<?php

namespace FMW;

use Countable,
	Iterator;

/** 
 * 
 * Classe Config
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, Hugo Mastromauro. 
 * @access public  
 * @package FMW 
 * @subpackage controllers
 *  
 */ 	
class Object 
	implements iObject, Countable, Iterator {
	
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	private $_stacks = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	private $_methods = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	protected $_data = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @var int
	 */
	protected $_count;
	
	/**
	 * 
	 * Enter description here ...
	 * @var int
	 */
	protected $_index;
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function __construct() {
		
		$arguments = func_get_args();
		
        foreach( get_class_methods( $this ) as $method ) {
			
        	if ( preg_match( '/init/', $method ) ) {
         		
        		$this->_stacks[$method] = call_user_func_array
		        (
		            array($this, $method), 
		            $arguments
		        );   	
			}
        }
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW.iObject::__call()
	 */
	public function __call($method, array $arguments) {
		
        $methodCh = "{$method}Ch";

        if (method_exists($this, $methodCh)) {
	        
        	$this->_stacks[$methodCh] = call_user_func_array
	        (
	            array($this, $methodCh), 
	            $arguments
	        );
	        
	        return $this;
	        
        } else {
        	
        	return call_user_func_array
	        (
	            array($this, $method), 
	            $arguments
	        );
        }
    }
	
	/**
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = null) {
    	
        $result = $default;
        if (array_key_exists($name, $this->_data)) {        	
            $result = $this->_data[$name];
        }
        return $result;
    }
    
    /**
     * 
     * Enter description here ...
     */
    public function getAll() {
    	
    	return $this->_data;
    }

    /**
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
    	    	
        return $this->get($name);
    }
    
	/**
     * 
     * Enter description here ...
     * @param string $name
     * @param mixed $value
     */
	public function set($name, &$value) {
		
		$this->_data[$name] = $value;
		$this->_count = count($this->_data);
	}
	
    /**
     * 
     * Enter description here ...
     * @param string $name
     * @param mixed $value
     */
	public function __set($name, $value) {
		
		$this->set($name, $value);
	}
	
	/**
	 *
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function __isset($name) {
		 
		return isset($this->_data[$name]);
	}
	
	/**
	 *
	 *
	 * @param  string $name
	 * @return void
	 */
	public function __unset($name) {
		 
		unset($this->_data[$name]);
		$this->_count = count($this->_data);
	}
	
	/**
     *
     * @return void
     */
    public function __clone() {
    	
      	$array = array();
      	foreach ($this->_data as $key => $value) {
          	if ($value instanceof \FMW\Object) {
				$array[$key] = clone $value;
          	} else {
            	$array[$key] = $value;
          	}
      	}
      	$this->_data = $array;
    }
	
    /**
     * (non-PHPdoc)
     * @see FMW.iStack::stack()
     */
    public function stack($method = NULL) {
    
    	if (isset($method))
    		return $this->_stacks[$method];
    
    	return $this->_stacks;
    }
    
    /**
     *
     * Enter description here ...
     * @param array $array
     */
    public function setArray( array $array ) {
    
    	foreach ($array as $key => $value) {
    			
    		$key = preg_replace('/[^a-zA-Z0-9\s]/', '', $key);
    		$this->_data[$key] = $value;
    	}
    
    	$this->_count = count($this->_data);
    }
    
    /**
     *
     * @return array
     */
    public function toArray() {
    	
        $array = array();
        $data = $this->_data;
        foreach ($data as $key => $value) {
            if ($value instanceof \FMW\Object) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }
	
	/**
	 * (non-PHPdoc)
	 * @see Countable::count()
	 */
	public function count() {
		return count($this->_data);
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::current()
	 */
	public function current() {
		 return current($this->_data);
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::next()
	 */
	public function next() {
		return ($this->_data);
		$this->_index++;
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::key()
	 */
	public function key() {
		 return key($this->_data);
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::valid()
	 */
	public function valid() {
		 return $this->_index < $this->_count;
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		reset($this->_data);
        $this->_index = 0;
	}
}
