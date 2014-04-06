<?php

namespace FMW\Controller;

use FMW\Application\Frontcontroller\Plugins\Assets,
	FMW\Utilities\File\Util;

/** 
 * 
 * Classe Abstrata AController
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Controller 
 * @subpackage FMW
 *  
 */ 
abstract class AController 
	extends \FMW\Object 
		implements \FMW\Controller\IController {		
	
	/**
	 * 
	 * @var FMW\Application\Frontcontroller
	 */
	protected $front;
	
	/**
	 * 
	 * @var FMW\View\View
	 */
	protected $view;
	
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
	 * @var array
	 */
	protected $meta = array();
	
	/**
	 * 
	 * @var string
	 */
	protected $slash = ' :: ';
	
	/**
	 * 
	 * @var \FMW\Application\Frontcontroller\Assets
	 */
	protected $assets;
		
	/**
	 * 
	 * @param \FMW\Application\Frontcontroller\Frontcontroller $front
	 */
	public function __construct( \FMW\Application\Frontcontroller\Frontcontroller $front ) {				
		
		/* FrontController */
		$this->front = $front;
		
		/* View */
		$this->view = $front->getView();
		
		/* Application */
		$this->app = $front->getApp();
		
		/* Router */
		$this->router = $front->getRouter();
		
		/* Request */
		$this->request = $front->getRequest();
		
		/* Entity (DBO) */
		$this->entityManager = $this->app->bootstrap()->stack('initDoctrine');

		/* Configurando url */
		$this->configureView();
		
		/* Http client */
		$this->http = \FMW\Loader\Loader::getInstance() 
						->loadClass( 'FMW\Utilities\Net\HTTPClient',
							array( array( 'baseurl' => $this->view->baseurl ) ) );
							
		
		parent::__construct();
	} 
	
	
	/**
	 * 
	 */
	protected function configureView() {
		
		$this->view->baseurl = $this->app->isApache() && $this->app->getConfig()->appmode == 'production' ?
									$this->app->getConfig()->baseurl . Util::rslash($this->router->getModule()) :
									$this->app->getConfig()->baseurl . 'index.php/' . Util::rslash($this->router->getModule());
		
		$this->view->base = $this->app->isApache() && $this->app->getConfig()->appmode == 'production' ?
									$this->app->getConfig()->baseurl . Util::rslash($this->router->getModule()) :
									$this->app->getConfig()->baseurl . 'index.php/';
		
		if ( $this->app->getConfig()->subdomain ) {
			
			$this->view->baseasset = $this->app->getConfig()->baseurl . 'public/';
					
			if ( $this->router->getModule() != 'admin\\' ) {
				
				$this->view->baseasset .= $this->app->getConfig()->subdomain . '/' .
											Util::rslash( $this->router->getModule() ) . 'assets/';
				
			} else {
				
				$this->view->baseasset .= Util::rslash( $this->router->getModule() ) . 'assets/';
				
			}
				
		} else {

			$this->view->baseasset = $this->app->getConfig()->baseurl . 'public/' .
										Util::rslash( $this->router->getModule() ) . 'assets/';

		}
		
		/* Instânciando plugin dos assets */
		
		$this->assets = new Assets( array(

				'baseasset' => $this->view->baseasset,
				'baseurl'	=> $this->view->baseurl
				
		), $this->front );
	}
	
	/**
	 * 
	 */
	public function debug() {
		error_reporting(E_ALL & ~E_NOTICE);
		ini_set('display_errors', true);
	}
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	public function setMetaCh($name, $value) {
		$this->meta[$name] = $value;
		return $this->meta;
	}
	
	/**
	 * 
	 * @param string $name
	 */
	public function removeMetaCh($name) {
		unset($this->meta[$name]);
	}
	
	/**
	 * 
	 * @param string $value
	 * @return multitype:
	 */
	public function setTitleCh( $value ) {
		
		if ( isset( $this->meta['title'] ) ) {
			$this->meta['title'] .= $this->slash . $value;
		}else{
			$this->meta['title'] = $value;
		}
		
		return $this->meta['title'];
	}
	
	/**
	 * 
	 * @param string $direction
	 */
	public function setTitleDirectionCh( $direction = 'r' ) {
		
		$new = '';
		if ($direction == 'l') {
			$rows = preg_split("/{$this->slash}/", $this->meta['title']);
			
			for ($i = count($rows)-1; $i >= 0; $i--){
				$new .= $rows[$i];
				
				if ( ! ($i == 0) )
					$new .= $this->slash;
			}
		}

		if ($direction == 'r') {
			$rows = preg_split("/{$this->slash}/", $this->meta['title']);
			
			for ($i = 0; $i < count($rows); $i++){
				$new .= $rows[$i];
				
				if (! ($i == (count($rows)-1)) )
					$new .= $this->slash;
			}
		}
		
		$this->meta['title'] = $new;
	}
	
	/**
	 * 
	 * @param string $slash
	 */
	public function formatTitleCh( $slash ) {
		
		$slash = trim($slash);
		$slashold = $this->slash; 
		$this->slash = str_pad($slash, count($slash) + 2, ' ', STR_PAD_BOTH);
		
		if (!empty($this->meta['title'])) {
			$this->meta['title'] = preg_replace("/{$slashold}/i", $this->slash, $this->meta['title']);
		}
	}
	
	/**
	 * 
	 */
	public function metaAssignCh() {
		$this->view->meta = $this->meta;
	}
	
	/**
	 * 
	 */
	public function assetsAssignCh() {
		$this->view->assets = $this->assets;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\IController::init()
	 */
	public function init() {}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\IController::preActionEvent()
	 */
	public function preActionEvent( array $params ) {}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IController::indexAction()
	 */
	public function indexAction( array $params ) {}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IController::postActionEvent()
	 */
	public function postActionEvent( array $params ) {
		
		/**
		 * Assign Meta
		 */
		$this->metaAssign();
		
		/**
		 * Assign assets
		 */
		$this->assetsAssign();
		
		/**
		 * Compile cache Asset
		 */
		$this->assets->compile();
		
		/**
		 * Render view
		 */
		$this->view->render();
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\IController::errorAction()
	 */
	public function errorAction( array $params ) {}
}