<?php

namespace FMW\Utilities\Validation;

/** 
 * 
 * Interface Class IRules
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
interface IRules {
	
	public static function validate( $method, array $params = null );
}
