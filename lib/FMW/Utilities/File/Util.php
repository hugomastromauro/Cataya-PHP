<?php

namespace FMW\Utilities\File;

/** 
 * 
 * Classe Util
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package File 
 * @subpackage Utilities
 *  
 */ 
class Util 
	extends \FMW\Object {	
		
	/**
	 * 
	 * @param string $value
	 * @return mixed
	 */
	public static function rslash( $value ) {
		
		return preg_replace('/\\\/', '/', $value);
	}
	
	/**
	 * 
	 * @param string $value
	 * @return string
	 */
	public static function removeslash( $value ) {
		
		return stripslashes(rtrim(ltrim($value, '/'), '/'));
	}
}