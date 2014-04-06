<?php

namespace CATAYA\Controller;

use	FMW\Utilities\Session\Session;

/**
 *
 * Classe ControllerServices
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Controller
 * @subpackage CATAYA
 *
 */
class ControllerServices
	extends \FMW\Controller\AControllerServices {
	
	/**
	 * 
	 * @var \FMW\Utilities\Session\Session
	 */
	protected $session;
	
	/**
	 * 
	 * @var array
	 */
	protected $params;
	
	/**
	 *
	 * @var \FMW\Utilities\Cache\MemcacheCache
	 */
	protected $memcache;

	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\AControllerServices::init()
	 */
	public function init () {
				
		$this->session = new Session( array('timeout' => $conf->geral->sessao ) );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IControllerServices::getAction()
	 */
	public function getAction( array $params ) {
		
		$this->setStatusHeader( 400 );
		$this->result = 'Serviço não disponível!';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IControllerServices::postAction()
	 */
	public function postAction( array $params ) {
		
		$this->setStatusHeader( 400 );
		$this->result = 'Serviço não disponível!';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IControllerServices::updateAction()
	 */
	public function updateAction( array $params ) {
		
		$this->setStatusHeader( 400 );
		$this->result = 'Serviço não disponível!';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IControllerServices::deleteAction()
	 */
	public function deleteAction( array $params ) {
		
		$this->setStatusHeader( 400 );
		$this->result = 'Serviço não disponível!';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\AControllerServices::authentication()
	 */
	public function authentication() {}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\AControllerServices::preActionEvent()
	 */
	public function preActionEvent( array $params) {
		
		parent::preActionEvent($params);
		
		$this->setMIMEType();
	}
}