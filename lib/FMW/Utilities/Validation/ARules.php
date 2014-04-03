<?php

namespace FMW\Utilities\Validation;

/** 
 * 
 * Abstract Class ARules
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
abstract class ARules {
		
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	private $_params;
	
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $_method;
	
	/**
	 * 
	 * Enter description here ...
	 * @var object
	 */
	private $_validation;
	
	/**
	 * 
	 * Enter description here ...
	 * @access public
	 * @param string $method
	 * @param array $params
	 * @return object
	 */
	public function __construct( $method, array $params = null ) {
		
		$this->_method = $method;		
		
		if (!is_null($params)) {
			$this->_params = $params;
		}
		
		return $this;
	}

	/**
	 * 
	 * Enter description here ...
	 * @access public
	 * @param Validation $validation
	 * @return void
	 */
	public function setValidation( $validation ) {
		$this->_validation = $validation;
	}
		
	/**
	 * 
	 * Enter description here ...
	 * @access public
	 * @return array 
	 */
	public function getParams() {
		return $this->_params;
	}
		
	/**
	 * 
	 * Enter description here ...
	 * @access public
	 * @return string
	 */
	public function getMethod() {
		return $this->_method;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @access public
	 * @return object
	 */
	public function getValidation() {
		return $this->_validation;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @access public
	 * @return string
	 */
	public function getMethodError() {
		$arr = explode('\\', get_called_class());				
		return end($arr) . ':' . $this->getMethod();
	}
}