<?php

namespace FMW\View\Helper;

/** 
 * 
 * Abstract Class AHelper
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
abstract class AHelper
	extends \FMW\Object	
		implements \FMW\View\Helper\IHelper {
	
	/**
	 * 
	 * Enter description here ...
	 * @var \FMW\Config
	 */
	protected $_config;
	
	/**
	 * 
	 * Enter description here ...
	 * @var \FMW\View\View
	 */
	protected $_view;
	
	/**
	 * 
	 * Enter description here ...
	 * @var \FMW\Router\Router
	 */
	protected $_router;
	
	/**
	 * 
	 * Enter description here ...
	 * @var \FMW\Utilities\Array\Array
	 */
	protected $_array;
	
	/**
	 * 
	 * @var \FMW\Utilities\Array\Array
	 */
	protected $_params;
		
	/**
	 * 
	 * Enter description here ...
	 */
	public function __construct( array $params = null ) {
		
		$this->_config = \FMW\Loader\Loader::getInstance() 
							->loadClass( 'FMW\Config' );
							
		$this->_view = \FMW\Loader\Loader::getInstance() 
							->loadClass( 'FMW\View\View' );
							
		$this->_router = \FMW\Loader\Loader::getInstance() 
							->loadClass( 'FMW\Router\Router' );
		
		if ($params)
			$this->_params = $params;
		
	}
}
