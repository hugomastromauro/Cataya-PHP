<?php

namespace FMW\Utilities\Validation;

/** 
 * 
 * Interface Class IValidation
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
interface IValidation {
	
	/**
	 * 
	 * 
	 * 
	 * $rules = array('formname' => 
	 *					array('label' => 'labelforformname', 'rules' => 'required|number|url'));
	 * 
	 * 
	 *
	 * $messages = array('error' => array('required' => 'Obrigatório o preenchimento do campo %s!',
	 *										'number' => 'Caractere inválido no campo (%s)!'));
	 *
	 *						
	 * @param array $rules
	 * @param array $messages
	 */
	//public function __construct ( array $rules, array $messages );
}
