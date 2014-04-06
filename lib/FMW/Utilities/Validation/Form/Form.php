<?php

namespace FMW\Utilities\Validation\Form;

/** 
 * 
 * Classe Form
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Form 
 * @subpackage Validation
 *  
 */ 
class Form 
	extends \FMW\Utilities\Validation\ARules
	implements \FMW\Utilities\Validation\IRules {	
	
	/**
	 * 
	 * @param string $method
	 * @param array $params
	 * @return \FMW\Utilities\Validation\Form\Form
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
	public function select($value, $field, $params = NULL) {
		
		return $value == 0 ? false : true;
	}
	
	/**
	 * 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return boolean
	 */
	public function requireValidData($value, $field, $params = NULL) {
		
		$pass = true;
		
		foreach( $params as $fieldValid ) {
			if ($value && !$this->getValidation()->getData($fieldValid)) {
				$pass = false;
			}
		}
		
		return $pass;
	}
}