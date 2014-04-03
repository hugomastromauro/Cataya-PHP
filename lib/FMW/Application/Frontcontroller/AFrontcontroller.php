<?php

namespace FMW\Application\Frontcontroller;

use FMW\Application\Frontcontroller\Plugins\APlugin,
	ReflectionClass;

/**
 *
 * Abstract Class AFrontcontroller
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, hugomastromauro.com.
 * @access public
 * @package FMW
 * @subpackage lib
 *
 */
abstract class AFrontcontroller
	extends \FMW\Object
		implements \FMW\Application\Frontcontroller\IFrontcontroller {

	/**
	 *
	 * Enter description here ...
	 * @var \FMW\Application
	 */
	protected $app;

	/**
	 *
	 * Enter description here ...
	 * @var \FMW\Application\Controller
	 */
	protected $class;

	/**
	 *
	 * Enter description here ...
	 * @var \FMW\Router\Router
	 */
	protected $router;

	/**
	 *
	 * Enter description here ...
	 * @var \FMW\View\View
	 */
	protected $view;

	/**
	 *
	 * Enter description here ...
	 * @var \FMW\Application\Request\Request
	 */
	protected $request;

	/**
	 *
	 * Enter description here ...
	 * @var string
	 */
	protected $controller;

	/**
	 *
	 * Enter description here ...
	 * @var \FMW\Utilities\Session\Session
	 */
	protected $session;

	/**
	 * Método controutor para instância do controller
	 *
	 * @method __construct
	 * @access public
	 * @param FMW\Application $app
	 * @return void
	 */
	public function __construct( \FMW\Application $app ) {

		$this ->app = $app;

		$this ->router = \FMW\Loader\Loader::getInstance()
							->loadClass( 'FMW\Router\Router' );

		$this ->request = \FMW\Loader\Loader::getInstance()
							->loadClass( 'FMW\Application\Request\Request',
								array( $this->router->getQuerystring() ) );

		$this ->view = \FMW\Loader\Loader::getInstance()
							->loadClass( 'FMW\View\View',
								array( $this ) );

		$this ->router ->route();
		
		$this->controller = 'controllers' .
								$this ->app ->getConfig() ->namespaceseparator;
		
	}
	
	/**
     * Método que chama o controller
     *
     * @method callController
     * @access public
     * @return void
     */
	public function callController() {
		
		$controller = $this ->controller .
							$this ->router ->getModule() .
								$this ->router ->getController();

		$methodClass = $this ->router ->getMethod() . 'Action';
		$methodHttp = $this ->router ->getMethod() . ucfirst(strtolower($_SERVER['REQUEST_METHOD'])) . 'Action';
		$newParam = $this ->router ->getMethod();
				
		$instObj = new ReflectionClass( $controller );
		
		$isService = false;
		
		if ($instObj->hasMethod($methodClass) === false) {
						
			$methodClass = $this ->app ->getConfig() ->controller ->method ->default;
			
			if ( $this->router->segments() >= 1 &&
					$this ->router ->getController() == $this ->app ->getConfig() ->controller ->default )
						$methodClass = $this ->app ->getConfig() ->controller ->method ->error;
			
			if ( $this->router->segments() >= 1 &&
					preg_match("/{$this->router->segment(1)}$/", $this ->router ->getModule()) &&
					$this ->router ->getController() == $this ->app ->getConfig() ->controller ->default )
						$methodClass = $this ->app ->getConfig() ->controller ->method ->error;
			
			$params = $this ->router ->getParams();
			$params = array_merge(array_slice($params, 0, 0), array($newParam), array_slice($params, 0));
			
			if ( $instObj->implementsInterface( '\FMW\Controller\IControllerServices' ) ) {
				
				$isService = true;
				
				$rMethod = strtolower($_SERVER['REQUEST_METHOD']);

				if ($rMethod == 'post') {
			
					$methodClass = 'postAction';
			
				} else if ($rMethod == 'get') {
					
					$methodClass = 'getAction';
						
				} else if ($rMethod == 'put') {
			
					$methodClass = 'updateAction';
						
				} else if ($rMethod == 'delete') {
			
					$methodClass = 'deleteAction';
				}
				
				$this->router->setParams( $params );
				
			} else if ( $instObj->hasMethod($methodHttp) === true ) {
				
				$methodClass = $methodHttp;
				 
			} else {
				
				$this->router->setMethod( 'index' );
				$this->router->setParams( $params );
				
			}
		}
		
		$this->class = $instObj ->newInstanceArgs( array( $this ) );

		if ( $instObj->hasMethod('preActionEvent') ) {
			$this->class->preActionEvent( $this ->router ->getParams() );
		}
		
		if ($isService && $instObj->hasMethod('getAuthenticate') && $this->class->getAuthenticate()) {
			if ($this->class->authentication()) {
				$this->class->$methodClass( $this ->router ->getParams() );
			} else {
				$this->class->indexAction( $this ->router ->getParams() );
			}
		} else {
			$this->class->$methodClass( $this ->router ->getParams() );
		}

		if ( $instObj->hasMethod('postActionEvent') ) {
			$this->class->postActionEvent( $this ->router ->getParams() );
		}

		unset($instObj);
	}

	/**
	 * Método que retorna a classe view
	 *
	 * @method getView
	 * @access public
	 * @return FMW\View\View
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * Método que retorna a classe view
	 *
	 * @method getRequest
	 * @access public
	 * @return FMW\Application\Request\Request
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Método que retorna a classe FMW\Application
	 *
	 * @method getApp
	 * @access public
	 * @return FMW\Application
	 */
	public function getApp() {
		return $this->app;
	}

	/**
	 * Método que retorna a classe FMW\Router
	 *
	 * @method getRouter
	 * @access public
	 * @return FMW\Router
	 */
	public function getRouter() {
		return $this->router;
	}

	/**
	 * Método que retorna a classe FMW\Utilities\Session\Session
	 *
	 * @method getSession
	 * @access public
	 * @return FMW\Utilities\Session\Session
	 */
	public function getSession() {
		return $this->session;
	}

	/**
	 *
	 * Enter description here ...
	 *
	 * @method setPlugin
	 * @access public
	 * @return FMW\Applications\Frontcontroller\Plugins\Plugin
	 */
	public function setPlugin( Array $plugin ) {

		if (is_array($plugin[0])) {

			foreach ($plugin as $key => $value) {

				if ( is_object( $value['object'] ) && $value['object'] instanceof APlugin ) {
					if (!isset($this->view->$value['name'])) {
						$this->view->$value['name'] = $value['object'];
					}
				}
			}

		} else {

			if ( is_object( $plugin['object'] ) && $plugin['object'] instanceof APlugin ) {
				if (!isset($this->view->$plugin['name'])) {
					$this->view->$plugin['name'] = $plugin['object'];
				}
			}
		}
	}
}