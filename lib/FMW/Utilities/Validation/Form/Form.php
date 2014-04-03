<?php

namespace FMW\Utilities\Validation\Form;

/** 
 * 
 * Class Form
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Form 
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
     * Method that validates select
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
     */
	public function select($value, $field, $params = NULL) {
		
		return $value == 0 ? false : true;
	}
	
	/**
	 * Method that validates field if another is correct
	 * @access public
	 * @param string $value
	 * @param string $field
	 * @param array $params
	 * @return bool
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