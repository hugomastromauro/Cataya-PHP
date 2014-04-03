<?php

/**
 * 
 * Enter description here ...
 * @author hugo
 *
 */
namespace FMW\Application\Bootstrap;

/** 
 * 
 * Class Bootstrap
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Bootstrap 
	extends \FMW\Application\Bootstrap\ABootstrap {

	/**
	 * Método construtor que recupera a aplicação
	 * @access public
	 * @return void
	 */
	public function __construct( \FMW\Application $app ) {
		
		parent::__construct( $app );
				
	}
}
