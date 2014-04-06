<?php

namespace FMW\Application\Bootstrap;

/** 
 * 
 * Classe Bootstrap
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Bootstrap 
 * @subpackage Application
 *  
 */ 
class Bootstrap 
	extends \FMW\Application\Bootstrap\ABootstrap {

	/**
	 * 
	 * @param \FMW\Application $app
	 */
	public function __construct( \FMW\Application $app ) {
		
		parent::__construct( $app );
				
	}
}
