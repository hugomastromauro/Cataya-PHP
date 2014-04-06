<?php

namespace FMW\View;

/** 
 * 
 * Interface de Classe IView
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package View 
 * @subpackage FMW
 *  
 */  
interface IView {	
	
	/**
	 * 
	 * @param \FMW\Application\Frontcontroller\Frontcontroller $front
	 */
	public function __construct( \FMW\Application\Frontcontroller\Frontcontroller $front );
	
}
