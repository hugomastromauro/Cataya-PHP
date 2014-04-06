<?php

namespace FMW\Utilities\Validation;

/** 
 * 
 * Interface de Classe IValidation
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Validation 
 * @subpackage Utilities
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
