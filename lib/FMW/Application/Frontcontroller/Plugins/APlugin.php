<?php

namespace FMW\Application\Frontcontroller\Plugins;

/** 
 * 
 * Abstract Class Plugin
 * 
 * $teste = array(
 *
 *		array('name' => 'teste', 'object' => new \FMW\Application\Frontcontroller\Plugins\Plugin()),
 *		array('name' => 'teste', 'object' => new \FMW\Application\Frontcontroller\Plugins\Plugin())
 *		
 *	);
 *		
 *	$this->front->setPlugin( $teste );
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
abstract class APlugin	
	implements \FMW\Application\Frontcontroller\Plugins\IPlugin {
	
	public function __construct() {
		
		
	}	
}
