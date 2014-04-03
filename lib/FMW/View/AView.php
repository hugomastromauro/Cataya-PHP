<?php

namespace FMW\View;

use FMW\Utilities\File\Util;

/** 
 * 
 * Abstract Class AView
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
abstract class AView
	extends \FMW\Utilities\Template\ATemplate
		implements \FMW\View\IView {
			
	/**
	 * 
	 * Enter description here ...
	 * @var FMW_Application_Frontcontroller_Frontcontroller
	 */
	protected $front;
		
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	protected $helpers = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $_path;
		
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	private $_layout = array( 'key' => null, 'params' => null );
	
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	private $_partial = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	private $_templates = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @var \FMW\Utilities\Cache\ACache
	 */
	private $_cache;
	
	/** 
     * Construtor da classe
     * @access public 
     * @param array $params   
     * @return void 
     */ 
	public function __construct( \FMW\Application\Frontcontroller\Frontcontroller $front ) {
		
		parent::__construct();
		
		$this ->front = $front;
		$this->setToken( $front->getApp()->getConfig()->view->token );
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $name
	 * @param mixed $value
	 */
	public function assign($name, $value) {
		
		$this->set($name, $value);	
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $key
	 * @param array $params
	 */ 	
	public function layout( $key, array $params = null, array $templates = null ) {

		$this->_layout['key'] = $key;
		$this->_layout['params'] = $params;
		
		$this->_templates = $templates;
	}
	
	/**
	 *
	 * Enter description here ...
	 * @param string $key
	 * @param array $params
	 */
	public function template( $key, array $params = null ) {
		
		if ( count( $this->_templates ) >= 1 ) {
			foreach( $this->_templates as $template ) {
				
				if ( $template['template'][$key] ) {
					
					$cparams = json_decode( $template['opcoes'] ); 
					
					if ( is_array( $cparams ) )
						$params = array_merge( $cparams, $params );
					
					$this->partial_javascript = $template['javascript'];
					$this->partial_css = $template['css'];
									
					$this->render( $template['template'][$key], $params );
					
				}
			}
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $key
	 * @param array $params
	 */
	public function partial( $key, array $params = null ) {
	
		if ( is_null( $params ) ) {
			if ( isset( $this->_partial[$key] ) )
				$params = $this->_partial[$key];
		}

		$this->render( $key, $params );
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $key
	 * @param array $params
	 */
	public function setPartial( $key, array $params = null ) {
		$this->_partial[$key] = $params;
	} 
		
	/**
	 * 
	 * $params = array(
	 * 		'cache' 	=> [true/false],
	 * 		'lifetime' 	=> [integer],
	 * 		'type'		=> [file],
	 * 		'compile'	=> [true/false] optional,
	 * 		'devices'	=> [phone/tablet/computer]
	 * )
	 * 
	 * @param string $key
	 * @param array $params
	 * @throws Exception
	 */
	public function render( $key = null, array $params = null ) {

		$type = 'content';
		
		$subdomain =  $this ->front ->getApp() ->getConfig() ->subdomain;
		$modulepath = $this ->front ->getApp() ->getConfig() ->controller ->module ->path;
		
		if ( $key == null && $params == null ) {
			$key = $this->_layout['key'];
			$params = $this->_layout['params'];
			$type = 'layout';
		}
			
		if ( $params['devices'] && is_array( $params['devices'] ) ) {
			
			$detect = new \FMW\Utilities\Device\MobileDetect();
			$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
			
			if (!in_array($deviceType, $params['devices']))
				return null;
		}
			
		$this->assignHelpers();
		
		if ( ! isset( $this-> _path ) ) $this -> _path = $modulepath;
		
		$test = preg_split('/:/', $key);		
		
		if ( count($test) > 1 ) {
			$module = $test[0] . DIRECTORY_SEPARATOR;
			$key = $test[1];
		} else {
			$module = $this ->front ->getRouter() ->getModule();
		}
		
		$path = $this ->_path . Util::rslash( $module );
		
		/*
		 * Verifica se existe o arquivo no diretório principal
		 * 
		 */
		if ( $subdomain && $module != 'admin\\' ) {
			
			$file = $this ->_path . $subdomain . DIRECTORY_SEPARATOR . Util::rslash( $module ) . $type . DIRECTORY_SEPARATOR . $key . '.php';
			
			if ( !file_exists( $file ) )
				$file = $path . $type . DIRECTORY_SEPARATOR . $key . '.php';
			
		} else {
			
			$file = $path . $type . DIRECTORY_SEPARATOR . $key . '.php';
		}
	
		if ( ! ( file_exists( $file ) ) )
			throw new Exception ( "Não foi possível abrir o arquivo: {$file}" );					
		
		if ( $params['cache'] && 
				isset($this->_cache) && 
					$this ->front ->getApp() ->getConfig() ->appmode == 'production' ) {
			
			
			$lifetime = isset( $params['lifetime'] ) ? $params['lifetime'] : 200; 
			
			if ( !isset( $params['type'] ) || $params['type'] == 'file' ) {
				
				if ( $this->_cache->contains( $key ) === false )
					$this->_cache->save( $key, $this->compile( $file, $path, $params ), $lifetime );
			
				echo $this->_cache->fetch( $key );
			}
			 
		} else {
			
			/*
			 * Compilar o layout com as variáveis vindas do bd
			 */
			echo $this->compile( $file, $path, $params );
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param \FMW\Utilities\ACache $cache
	 */
	public function setCache( $cache ) {
		
		if ( $cache instanceof \FMW\Utilities\Cache\ACache ) {
			$this->_cache = $cache;
		} else {
			throw new Exception ( "Classe cache não extende classe base!" );	
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $key
	 */
	public function isCached( $key ) {
		
		if ( isset($this->_cache ) )
			return $this->_cache->contains( $key );
			
		return false;
	}
		
	/**
	 * 
	 * Enter description here ...
	 * @param string $path
	 */
	public function setPath( $path ) {
		
		$this->_path = $path;
	}
	
	/**
	 * 
	 * @param string $name
	 */
	public function getHelper( $name ) {
		return $this->helpers[$name];
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $name
	 * @param \FMW\View\Helper $helper
	 */
	public function setHelper( $name, $helper ) {
		
		if ( $helper instanceof \FMW\View\Helper\AHelper ) {
			$this->helpers[$name] = $helper;
		}else{
			throw new Exception ( "Helper não extende a classe AHelper!" );
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	private function assignHelpers() {
		
		if (isset($this->helpers)) {
			foreach($this->helpers as $key => $value) {
				$this->$key = $value;	
			}
		}
	}
}
