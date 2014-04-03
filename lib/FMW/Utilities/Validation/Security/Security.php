<?php

namespace FMW\Utilities\Validation\Security;

/** 
 * 
 * Class Security
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Security 
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
     * Method that confirm passwords
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
     */
	public function password($value, $field, $params = NULL) {
						
		if (!isset($params[0]) or !isset($params[1])) return false;
		
		if(!(isset($value)) or strlen($value) < $params[0])	return false;			
		
		if ($value != $this->getData($params[1])) return false;
		
		return true;
	}
}