<?php

namespace FMW\Utilities\Validation;

/** 
 * 
 * Classe Abstrata ARules
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Validation 
 * @subpackage Utilities
 *  
 */ 
abstract class ARules {
		
	/**
	 * 
	 * @var array
	 */
	private $_params;
	
	/**
	 * 
	 * @var string
	 */
	private $_method;
	
	/**
	 * 
	 * @var object
	 */
	private $_validation;
	
	/**
	 * 
	 * @param string $method
	 * @param array $params
	 * @return \FMW\Utilities\Validation\ARules
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
	 * @param object $validation
	 */
	public function setValidation( $validation ) {
		$this->_validation = $validation;
	}
		
	/**
	 * 
	 * @return multitype:
	 */
	public function getParams() {
		return $this->_params;
	}
		
	/**
	 * 
	 * @return string
	 */
	public function getMethod() {
		return $this->_method;
	}
	
	/**
	 * 
	 * @return object
	 */
	public function getValidation() {
		return $this->_validation;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getMethodError() {
		$arr = explode('\\', get_called_class());				
		return end($arr) . ':' . $this->getMethod();
	}
}