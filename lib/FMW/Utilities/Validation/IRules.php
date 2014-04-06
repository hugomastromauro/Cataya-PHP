<?php

namespace FMW\Utilities\Validation;

/** 
 * 
 * Interface de Classe IRules
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Validation 
 * @subpackage Utilities
 *  
 */ 
interface IRules {
	
	/**
	 * 
	 * @param string $method
	 * @param array $params
	 */
	public static function validate( $method, array $params = null );
}
