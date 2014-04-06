<?php

namespace FMW\Utilities\Debugger;

/** 
 * 
 * Interface de Classe IDebug
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Debugger 
 * @subpackage Utilities
 *  
 */ 
interface IDebug {	
	
	/**
	 * 
	 */
	public function init();
	
	/**
	 * 
	 * @param array $params
	 */
	public function postActionEvent( array $params );
}
