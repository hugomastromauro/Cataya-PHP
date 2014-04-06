<?php

namespace FMW\Utilities\Validation\Number;

/** 
 * 
 * Classe Number
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Number 
 * @subpackage Validation
 *  
 */ 
class Number 
	extends \FMW\Utilities\Validation\ARules
	implements \FMW\Utilities\Validation\IRules {	
	
	/**
	 * 
	 * @param string $method
	 * @param array $params
	 * @return \FMW\Utilities\Validation\Number\Number
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
	public function numeric($value, $field, $params = null) {
		
		return is_numeric($value) ? true : false;
	}
	
	/**
	 * 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return boolean
	 */
	public function integer($value, $field, $params = null) {
		return intval($value) ? true : false;
	}
	
	/**
	 * 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return boolean
	 */
	public function number($value, $field, $params = null) {
		
		return $value == $params[0] ? true : false;
	}
}