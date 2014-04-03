<?php

namespace FMW\Utilities\Debugger;

/** 
 * 
 * Interface Class IDebug
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
interface IDebug {	
	
	/**
	 * Chamar o método Tracking::start();
	 */
	public function init();
	
	/**
	 * Chamar o método Tracking::end();
	 * 
	 * @param array $params
	 */
	public function postActionEvent( array $params );
}
