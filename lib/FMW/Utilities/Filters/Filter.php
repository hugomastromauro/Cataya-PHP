<?php

namespace FMW\Utilities\Filters;

/** 
 * 
 * Class Filter
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Filter 
	extends \FMW\Object {	
	
	/** 
     * Método que previne ataques por injeção de códigos
     * @access public 
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