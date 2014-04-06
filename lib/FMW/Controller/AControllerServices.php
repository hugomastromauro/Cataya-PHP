<?php

namespace FMW\Controller;

/** 
 * 
 * Classe Abstrata AControllerServices
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Controller 
 * @subpackage FMW
 *  
 */ 
abstract class AControllerServices
	extends \FMW\Object 
		implements \FMW\Controller\IController, \FMW\Controller\IControllerServices {		
	
	/**
	 * 
	 * @var FMW\Application\Frontcontroller
	 */
	protected $front;
	
	/**
	 * 
	 * @var FMW\Application\Request\Request
	 */
	protected $request;
	
	/**
	 * 
	 * @var FMW\Application
	 */
	protected $app;
	
	/**
	 * 
	 * @var FMW\Router\Router
	 */
	protected $router;
	
	/**
	 * 
	 * @var FMW\Utilities\Net\HTTPClient
	 */
	protected $http;
	
	/**
	 * 
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
	 * 
	 * @param \FMW\Application\Frontcontroller\Frontcontroller $front
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
	 * 
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
	 * (non-PHPdoc)
	 * @see \FMW\Controller\IController::errorAction()
	 */
	public function errorAction( array $params ) {}
}