<?php

namespace FMW\Utilities\Validation\String;

/** 
 * 
 * Classe String
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package String 
 * @subpackage Validation
 *  
 */ 
class String 
	extends \FMW\Utilities\Validation\ARules
	implements \FMW\Utilities\Validation\IRules {	
	
	/**
	 * 
	 * @param string $method
	 * @param array $params
	 * @return \FMW\Utilities\Validation\String\String
	 */
	public static function validate( $method, array $params = null ) {
				
		return new self( $method, $params );		
	}
	
	/**
	 * 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return boolean
	 */
	public function charlen($value, $field, $params = NULL) {
		
		if(!isset($value) or strlen($value) < $params[0])
		{
			return false;
		}		
		return true;	
	}
	
	/**
	 * 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return boolean
	 */
	public function required($value, $field, $params = NULL) {

		if (!isset($value))
		{
			return false;
		}
		return true;
	}
}