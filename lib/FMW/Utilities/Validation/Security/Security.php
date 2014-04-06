<?php

namespace FMW\Utilities\Validation\Security;

/** 
 * 
 * Classe Security
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Security 
 * @subpackage Validation
 *  
 */ 
class Security 
	extends \FMW\Utilities\Validation\ARules
	implements \FMW\Utilities\Validation\IRules {	
	
	/**
	 * 
	 * @param string $method
	 * @param array $params
	 * @return \FMW\Utilities\Validation\Security\Security
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
	public function password($value, $field, $params = NULL) {
						
		if (!isset($params[0]) or !isset($params[1])) return false;
		
		if(!(isset($value)) or strlen($value) < $params[0])	return false;			
		
		if ($value != $this->getData($params[1])) return false;
		
		return true;
	}
}