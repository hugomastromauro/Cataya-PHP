<?php

namespace FMW\View;

/** 
 * 
 * Interface Class IView
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */  
interface IView {	
	
	/**
	 * 
	 * Enter description here ...
	 * @param \FMW\Application\Frontcontroller\Frontcontroller $front
	 */
	public function __construct( \FMW\Application\Frontcontroller\Frontcontroller $front );
	
}
