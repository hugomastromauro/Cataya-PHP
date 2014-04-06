<?php

namespace FMW\Utilities\Filters;

/** 
 * 
 * Classe Filter
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Filters 
 * @subpackage Utilities
 *  
 */ 
class Filter 
	extends \FMW\Object {	
	
	/**
	 * 
	 * @param string $value
	 * @return mixed
	 */
	public function sanitize( $value )
	{	
		/// TODO: Concluir a sanitização dos dados aqui	
		if ( !is_array( $value ) ) {
			
			return filter_var( $value, FILTER_SANITIZE_MAGIC_QUOTES );
			
		} else {
		
			foreach ($value as $k => $v ) {
				
				$value[$k] = $this->sanitize( $v );
			}
		}
		
		return $value;
	}
}