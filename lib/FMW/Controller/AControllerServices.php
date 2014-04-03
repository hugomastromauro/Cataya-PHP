<?php

namespace FMW\Controller;

/** 
 * 
 * Abstract Class AControllerServices
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
abstract class AControllerServices
	extends \FMW\Object 
		implements \FMW\Controller\IController, \FMW\Controller\IControllerServices {		
	
	/**
	 * 
	 * Enter description here ...
	 * @var FMW\Application\Frontcontroller
	 */
	protected $front;
	
	/**
	 * 
	 * Enter description here ...
	 * @var FMW\Application\Request\Request
	 */
	protected $request;
	
	/**
	 * 
	 * Enter description here ...
	 * @var FMW\Application
	 */
	protected $app;
	
	/**
	 * 
	 * Enter description here ...
	 * @var FMW\Router\Router
	 */
	protected $router;
	
	/**
	 * 
	 * Enter description here ...
	 * @var FMW\Utilities\Net\HTTPClient
	 */
	protected $http;
	
	/**
	 * 
	 * Enter description here ...
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $entityManager;
	
	/**
	 * 
	 * @var boolean
	 */
	private $authenticate = false;
	
	/**
	 * 
	 * @var number
	 */
	private $status;
		
	/** 
     * Construtor da classe
     * @method __construct
     * @access public     
     * @return void 
     */
	public function __construct( \FMW\Application\Frontcontroller\Frontcontroller $front ) {				
		
		/* FrontController */
		$this->front = $front;
		
		/* Application */
		$this->app = $front->getApp();
		
		/* Router */
		$this->router = $front->getRouter();
		
		/* Request */
		$this->request = $front->getRequest();
		
		/* Entity (DBO) */
		$this->entityManager = $this->app->bootstrap()->stack('initDoctrine');
		
		$baseurl = $this->app->isApache() && $this->app->getConfig()->appmode == 'production' ?
									$this->app->getConfig()->baseurl . \FMW\Utilities\File\Util::rslash($this->router->getModule()) :
										$this->app->getConfig()->baseurl . 'index.php/' . \FMW\Utilities\File\Util::rslash($this->router->getModule());
		
		/* Http client */
		$this->http = \FMW\Loader\Loader::getInstance() 
						->loadClass( 'FMW\Utilities\Net\HTTPClient',
							array( array( 'baseurl' => $baseurl ) ) );

		parent::__construct();
	} 
	
	/**
	 *
	 * @param string $mimetype
	 */
	protected function setMIMEType( $mimetype = 'json' ) {
			
		switch ($mimetype)
		{
			case 'json':
				header('Content-Type: application/json; charset=utf-8');
				break;
			case 'xml':
				header('Content-Type: application/xml; charset=utf-8');
				break;
			default:
				break;
		}
	}
	
	/**
	 * 
	 * @param number $status
	 */
	protected function setStatusHeader( $status = 200 ) {
		
		$this->status = $status;
	}
	
	/**
	 * Debug aplication
	 */
	protected function debug() {
		
		error_reporting(E_ALL & ~E_NOTICE);
		ini_set('display_errors', true);
	}
		
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IController::init()
	 */
	public function init() {}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IController::indexAction()
	 */
	public function indexAction( array $params ) {}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\IControllerServices::authentication()
	 */
	public function authentication() {}
	
	/**
	 * 
	 * @param boolean $bool
	 */
	public function setAuthenticate( $bool ) {
		$this->authenticate = $bool;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function getAuthenticate() {
		return (bool)$this->authenticate;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IController::preActionEvent()
	 */
	public function preActionEvent( array $params ) {
		
		header('Access-Control-Allow-Orgin: *');
		header('Access-Control-Allow-Methods: *');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IController::postActionEvent()
	 */
	public function postActionEvent( array $params ) {
		
		$this->setStatusHeader( $this->status );
		
		echo json_encode( $this->_data );
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param array $params
	 */
	public function errorAction( array $params ) {}
}