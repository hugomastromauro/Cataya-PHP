<?php

namespace FMW\Application\Frontcontroller\Plugins;

/** 
 * 
 * Classe Abastrata Plugin
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
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Plugins 
 * @subpackage Frontcontroller
 *  
 */ 
abstract class APlugin	
	implements \FMW\Application\Frontcontroller\Plugins\IPlugin {
	
	/**
	 * 
	 */
	public function __construct() {}	
}
