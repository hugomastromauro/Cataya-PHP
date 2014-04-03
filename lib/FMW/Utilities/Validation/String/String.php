<?php

namespace FMW\Utilities\Validation\String;

/** 
 * 
 * Class String
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class String 
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
     * Method that validates the string length
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
     */
	public function charlen($value, $field, $params = NULL) {
		
		if(!isset($value) or strlen($value) < $params[0])
		{
			return false;
		}		
		return true;	
	}
	
	/**
	 * @access public 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return bool 
	 */
	public function required($value, $field, $params = NULL) {

		if (!isset($value))
		{
			return false;
		}
		return true;
	}
}