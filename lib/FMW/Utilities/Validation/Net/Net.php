<?php

namespace FMW\Utilities\Validation\Net;

/** 
 * 
 * Class Net
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Net 
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
     * Method that validates email
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
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
     * Method that optimizes url
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
     */
	public function urlseo($value, $field, $params = NULL)
	{
		$this->getValidation()->setData(\FMW\Utilities\String\String::seo($value), $field);
		return true;
	}
	
	/** 
     * Method that validates url
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
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
     * Method that validates IP
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
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