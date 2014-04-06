<?php

namespace FMW\Utilities\Validation\Date;

/** 
 * 
 * Classe Date
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Date 
 * @subpackage Validation
 *  
 */ 
class Date 
	extends \FMW\Utilities\Validation\ARules
	implements \FMW\Utilities\Validation\IRules {	
	
	/**
	 * 
	 * @param string $method
	 * @param array $params
	 * @return \FMW\Utilities\Validation\Date\Date
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
	public function datetime($value, $field, $params = NULL)
	{		
		if(!preg_match('/^(00|19|20)[0-9]{2}[- \/.](0[0-9]|0[012])[- \/.](0[0-9]|[12][0-9]|3[01]) [0-9]{2}:[0-9]{2}$/', $value))
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
	public function date($value, $field, $params = NULL)
	{
		if(!preg_match('/^(00|19|20)[0-9]{2}[- \/.](0[0-9]|0[012])[- \/.](0[0-9]|[12][0-9]|3[01])$/', $value))
		{
			return false;
		}		
		return true;	
	}
}