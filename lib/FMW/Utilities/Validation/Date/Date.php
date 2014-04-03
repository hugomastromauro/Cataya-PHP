<?php

namespace FMW\Utilities\Validation\Date;

/** 
 * 
 * Class Date
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Date 
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
     * Method that validates the date and time in the format 0000-00-00 00:00:00
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
     */
	public function datetime($value, $field, $params = NULL)
	{		
		if(!preg_match('/^(00|19|20)[0-9]{2}[- \/.](0[0-9]|0[012])[- \/.](0[0-9]|[12][0-9]|3[01]) [0-9]{2}:[0-9]{2}$/', $value))
		{
			return false;
		}		
		return true;	
	}

	/** 
     * Method that validates the date 0000-00-00
     * @access public 
     * @param string $value
     * @param string $field    
     * @param array $params    
     * @return bool 
     */
	public function date($value, $field, $params = NULL)
	{
		if(!preg_match('/^(00|19|20)[0-9]{2}[- \/.](0[0-9]|0[012])[- \/.](0[0-9]|[12][0-9]|3[01])$/', $value))
		{
			return false;
		}		
		return true;	
	}
}