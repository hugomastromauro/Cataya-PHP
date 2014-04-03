<?php

namespace FMW\Utilities\File;

/** 
 * 
 * Class Util
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Util 
	extends \FMW\Object {	
		
	/** 
     * Método que troca barras
     * @access public 
     * @param string $value          
     * @return string 
     */
	public static function rslash( $value ) {
		
		return preg_replace('/\\\/', '/', $value);
	}
	
	/** 
     * Método que remove barras
     * @access public 
     * @param string $value          
     * @return string 
     */
	public static function removeslash( $value ) {
		
		return stripslashes(rtrim(ltrim($value, '/'), '/'));
	}
}