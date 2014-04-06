<?php

namespace FMW\Utilities\Validation\Net;

/** 
 * 
 * Classe Net
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Net 
 * @subpackage Validation
 *  
 */ 
class Net 
	extends \FMW\Utilities\Validation\ARules
	implements \FMW\Utilities\Validation\IRules {	
	
	/**
	 * 
	 * @param string $method
	 * @param array $params
	 * @return \FMW\Utilities\Validation\Net\Net
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
	public function email($value, $field, $params = null)
	{
		
		if (!$value && !$params['required']) {
			return true;
		} else if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return boolean
	 */
	public function urlseo($value, $field, $params = NULL)
	{
		$this->getValidation()->setData(\FMW\Utilities\String\String::seo($value), $field);
		return true;
	}
	
	/**
	 * 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return boolean
	 */
	public function url($value, $field, $params = NULL) 
	{
		
		if (!$value && !$params['required']) {
			return true;
		} else if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * @param string $value
	 * @param string $field
	 * @param string $params
	 * @return boolean
	 */	
	public function ip($value, $field, $params = NULL) 
	{
		
		if (!$value && !$params['required']) {
			return true;
		} else if (filter_var($value, FILTER_VALIDATE_IP)) {
			return true;
		}
		
		return false;
	}
}