<?php

namespace FMW\View\Helper;

/** 
 * 
 * Classe Abstrata AHelper
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Helper 
 * @subpackage View
 *  
 */ 
abstract class AHelper
	extends \FMW\Object	
		implements \FMW\View\Helper\IHelper {
	
	/**
	 * 
	 * @var \FMW\Config
	 */
	protected $_config;
	
	/**
	 * 
	 * @var \FMW\View\View
	 */
	protected $_view;
	
	/**
	 * 
	 * @var \FMW\Router\Router
	 */
	protected $_router;
	
	/**
	 * 
	 * @var \FMW\Utilities\Array\Array
	 */
	protected $_array;
	
	/**
	 * 
	 * @var array
	 */
	protected $_params;
		
	/**
	 * 
	 * @param array $params
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
