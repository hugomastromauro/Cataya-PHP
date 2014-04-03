<?php

namespace FMW\Utilities\Validation\Number;

/** 
 * 
 * Class Number
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Number 
	extends \FMW\Utilities\Validation\ARules
	implements \FMW\Utilities\Validation\IRules {	
	
	/**
	 * 
	 * Enter description here ...
	 * @access public
	 * @param string $method
	 * @param array $params
	 * @return object
	 */
	public static function validate( $method, array $params = null ) {
				
		return new self( $method, $params );		
	}
	
	/** 
     * Method that validates numbers
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
     */
	public function numeric($value, $field, $params = null) {
		
		return is_numeric($value) ? true : false;
	}
	
	/**
	 * Method that validates numbers
	 * @access public
	 * @param string $value
	 * @param string $field
	 * @param array $params
	 * @return bool
	 */
	public function integer($value, $field, $params = null) {
		return intval($value) ? true : false;
	}
	
	/**
	 * Method that validates numbers
	 * @access public
	 * @param string $value
	 * @param string $field
	 * @param array $params
	 * @return bool
	 */
	public function number($value, $field, $params = null) {
		
		return $value == $params[0] ? true : false;
	}
}