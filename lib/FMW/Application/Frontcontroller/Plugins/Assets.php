<?php

namespace FMW\Application\Frontcontroller\Plugins;

use FMW\Utilities\Cache\FileCache,
	FMW\Utilities\File\Util;

/**
 *
 * Classe Assets
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Plugins
 * @subpackage Frontcontroller
 *
 */
class Assets
	extends \FMW\Application\Frontcontroller\Plugins\APlugin {

	/**
	 * 
	 * @var string
	 */
	private $_baseasset;

	/**
	 * 
	 * @var string
	 */
	private $_baseurl;
	
	/**
	 * 
	 * @var string
	 */
	private $_base;

	/**
	 * 
	 * @var array
	 */
	private $_css = Array();
	
	/**
	 * 
	 * @var array
	 */
	private $_cssCache = Array();

	/**
	 * 
	 * @var array
	 */
	private $_javascript = Array();
	
	/**
	 * 
	 * @var array
	 */
	private $_javascriptCache = Array();
	
	/**
	 * 
	 * @var array
	 */
	private $_javascriptHttp = Array();
	
	/**
	 * 
	 * @var array
	 */
	private $_plugins = Array();
	
	/**
	 * 
	 * @var int
	 */
	private $_cachetime = 18000;
	
	/**
	 * 
	 * @var \FMW\Application\Frontcontroller\AFrontcontroller
	 */
	private $_front;

	/**
	 * 
	 * @param array $params
	 * @param \FMW\Application\Frontcontroller\AFrontcontroller $front
	 * @throws Exception
	 */
	public function __construct( array $params, \FMW\Application\Frontcontroller\AFrontcontroller $front ) {
		
		if ( !isset($params['baseasset']) || !isset($params['baseurl']) ) {
			throw new Exception ( "Pasta \"asset\" e a url base da aplicação não informadas!" );
		}
		
		$this->_baseasset = $params['baseasset'];
		$this->_baseurl = $params['baseurl'];
		$this->_cachetime |= $params['cachetime'];  
		
		$this->_base = $front->getApp()->getConfig()->baseurl . 'public/';
		
		$this->_front = $front;
	}

	/**
	 * 
	 * @param string $name
	 * @param array $values
	 * @param string $media
	 * @param string $baseasset
	 */
	public function setCss( $name, array $values, $media = 'all', $baseasset = false ) {
		
		$baseasset = $baseasset ? $this->setBaseAsset( $baseasset ) : $this->_baseasset;
		
		$baseurl = preg_quote( $this->_front->getApp()->getConfig()->baseurl, '/' );
		$assetlocal = preg_replace( "/{$baseurl}public\//", $this->_front->getApp()->getConfig()->controller->module->path, $baseasset );
		
		foreach ( $values as $key => $value ) {

			if ( !preg_match( '/.css/', $value ) )
				$value .= '.css'; 
				
			$params = '';
			
			if ( is_array( $value ) ) {
				
				foreach($value as $k => $v) {
					$params .= " {$k}='{$v}'";
				}
				
				if ( file_exists( $assetlocal . 'css/' . $key ) ) {
					$this->_css[$name][] = '<link rel="stylesheet" href="' . $baseasset . 'css/' . $key . '"' . $params . '>';
					$this->_cssCache[] = $assetlocal . 'css/' . $key;
				}
				
			} else {

				if ( file_exists( $assetlocal . 'css/' . $value ) ) {
					$this->_css[$name][] = '<link rel="stylesheet" href="' . $baseasset . 'css/' . $value . '" media="' . $media . '">';
					$this->_cssCache[] = $assetlocal . 'css/' . $value;
				}
			}
		}
	}

	/**
	 * 
	 * @param string $name
	 * @param array $values
	 * @param bool $baseasset
	 */
	public function setJavascript( $name, array $values, $baseasset = false ) {
		
		$baseasset = $baseasset ? $this->setBaseAsset( $baseasset ) : $this->_baseasset;
		
		$baseurl = preg_quote( $this->_front->getApp()->getConfig()->baseurl, '/' );
		$assetlocal = preg_replace( "/{$baseurl}public\//", $this->_front->getApp()->getConfig()->controller->module->path, $baseasset );
		
		foreach ( $values as $value ) {
			
			if ( !preg_match( '/.js/', $value ) )
				$value .= '.js';
			
			if ( strpos($value, 'http') === 0 || strpos($value, 'https') === 0 ) {
				
				$this->_javascriptHttp[$name][] = '<script src="' . $value . '" type="text/javascript"></script>';
				
			} else {
				
				if ( file_exists( $assetlocal . 'javascript/' . $value ) ) {
					$this->_javascript[$name][] = '<script src="' . $baseasset . 'javascript/' . $value . '" type="text/javascript"></script>';
					$this->_javascriptCache[] = $assetlocal . 'javascript/' . $value;
				}
			}
		}
	}
	
	/**
	 * 
	 * @param array $values
	 * @param bool $baseasset
	 */
	public function loadPlugin( array $values, $baseasset = false ) {
		
		$modulepath = $this ->_front ->getApp() ->getConfig() ->controller ->module ->path;
		$subdomain = $this->_front ->getApp() ->getConfig() ->subdomain;
		$module = Util::rslash( $this ->_front ->getRouter() ->getModule() );

		foreach($values as $plugin => $optional) {
			
			if (is_numeric($plugin))
				$plugin = $optional;
						
			if ( $baseasset ) {
				
				if ( file_exists( "{$modulepath}{$subdomain}/{$baseasset}/assets/plugins/{$plugin}/{$plugin}.json" ) ) {
					$baseplugin = $this->_base . $subdomain . '/' . $baseasset . '/assets/plugins/' . $plugin . '/';
				} else {
					$baseplugin = $this->_base . $baseasset . '/assets/plugins/' . $plugin . '/';
				}
				
			} else {

				if ( file_exists( "{$modulepath}{$subdomain}/{$module}assets/plugins/{$plugin}/{$plugin}.json" ) ) {
					$baseplugin = $this->_baseasset . 'plugins/' . $plugin . '/';
				} else {
					$baseplugin = $this->_base . $module . 'assets/plugins/' . $plugin . '/';
				}
				
			}
			
			$file = $baseplugin . $plugin . '.json';
												
			$json = $this->loadJsonFile($file);

			if ($json) {
				
				foreach($json['dependencies'] as $key => $value) {
					
					if ($key == 'js')
						$this->setJavascript($plugin . $key, $value, $baseplugin);
					
					if ($key == 'css')
						$this->setCss($plugin . $key, $value, 'all', $baseplugin);
				}
				
				if (is_array($optional)){
				
					foreach($optional as $key) {
				
						if ($json['optional']['js'][$key])
							$this->setJavascript($plugin . $key, $json['optional']['js'][$key], $baseplugin);
							
						if ($json['optional']['css'][$key])
							$this->setCss($plugin . $key, $json['optional']['css'][$key], 'all', $baseplugin);
					}
				}
			}
		}	
	}
	
	/**
	 * 
	 * @param string $javascript
	 * @return string
	 */
	public function getTagJavascript( $javascript ) {
		return '<script src="' . $javascript . '"></script>';
	}
	
	/**
	 *
	 * @param string $css
	 * @return string
	 */
	public function getTagCSS( $css ) {
		return '<link rel="stylesheet" href="' . $css . '" media="all">';
	}
	
	/**
	 * 
	 * @return Ambigous <\FMW\Application\Frontcontroller\Plugins\Ambigous, multitype:, multitype:unknown >
	 */
	public function getAllCss() {
		
		$subdomain = $this->_front ->getApp() ->getConfig() ->subdomain ? $this->_front ->getApp() ->getConfig() ->subdomain . '/' : '';
		
		if ( $this->_front->getApp()->getConfig()->appmode == 'production' ) {
			
			return array(
			
				$this->getTagCSS(
					$this->_base . $subdomain .
					\FMW\Utilities\File\Util::rslash( $this -> _front ->getRouter() ->getModule() ) . 'cache/' .
					$this -> _front ->getRouter() ->getController() . '_' .
					$this->_cachetime . '.css'
				)
			);
			
		} else {
			
			return $this->array_flatten( $this->_css );
			
		}
	}

	/**
	 * 
	 * @return multitype:string |Ambigous <\FMW\Application\Frontcontroller\Plugins\Ambigous, multitype:, multitype:unknown >
	 */
	public function getAllJavascript() {
		
		$subdomain = $this->_front ->getApp() ->getConfig() ->subdomain ? $this->_front ->getApp() ->getConfig() ->subdomain . '/' : '';
		
		if ( $this->_front->getApp()->getConfig()->appmode == 'production' ) {
					
			return array_merge( $this->array_flatten( $this->_javascriptHttp ), array( 
						
					$this->getTagJavascript( 			
						$this->_base . $subdomain .
						\FMW\Utilities\File\Util::rslash( $this -> _front ->getRouter() ->getModule() ) . 'cache/' . 
						$this -> _front ->getRouter() ->getController() . '_' . 
						$this->_cachetime . '.js' 
					) 
				)
			);
			
		} else {
			
			return array_merge( $this->array_flatten( $this->_javascriptHttp ), $this->array_flatten( $this->_javascript ) );
		}
	}

	/**
	 * 
	 * @param string $name
	 * @return multitype:
	 */
	public function getCss( $name ) {
		return $this->_css[$name];
	}

	/**
	 * 
	 * @param string $name
	 * @return multitype:
	 */
	public function getJavascript( $name ) {
		return $this->_javascript[$name];
	}
	
	/**
	 * 
	 * @param string $name
	 * @return multitype:
	 */
	public function getPlugin( $name ) {
		return $this->_plugins[$name];
	}
	
	/**
	 * 
	 * @param string $folder
	 * @return string
	 */
	public function getAssetFolder( $folder ) {
		return $this->_base . $folder . '/assets/';
	}

	/**
	 * 
	 * @param array $array
	 * @return Ambigous <multitype:, multitype:unknown >
	 */
	private function array_flatten( array $array ) {
  		$result = array();
  		foreach ($array as $key => $value) {
    		if (is_array($value)) {
      			$result = array_merge($result, $this->array_flatten($value));
    		}
    		else {
      			$result[$key] = $value;
    		}
  		}
  		return $result;
	}
	
	/**
	 * 
	 * Determina de qual caminho vem o recurso. Se é de um módulo ou não.
	 * 
	 * @param string $baseasset
	 */
	private function setBaseAsset($baseasset) {
		
		if (strpos($baseasset, 'http') === 0)
			return $baseasset;
		
		return $this->_base . $baseasset . '/assets/';
	}
	
	/**
	 * Minificar o Javascript e CSS
	 *  
	 */
	public function compile() {
		
		$path = $this -> _front ->getApp() ->getConfig() ->controller ->module ->path;
		$path .= $this -> _front ->getApp() ->getConfig() ->subdomain ? $this -> _front ->getApp() ->getConfig() ->subdomain . DIRECTORY_SEPARATOR : '';
		$path .= \FMW\Utilities\File\Util::rslash( $this -> _front ->getRouter() ->getModule() ) . 'cache';
		
		$fcache = new FileCache(array(
				'path' 	=> $path,
				'ext' 	=> 'js'
			)
		);
		
		if ( $fcache->contains( $this -> _front ->getRouter() ->getController() ) === false ) {
			
			$js = '';
			
			foreach ($this->_javascriptCache as $value) {
				$js .= file_get_contents( $value );
			}
			
			$js = \FMW\Utilities\Minify\JSMin::minify($js);
			$fcache->save( $this -> _front ->getRouter() ->getController(), $js, $this->_cachetime );
			
		}

		$fcache = new FileCache(array(
				'path' 	=> $path,
				'ext' 	=> 'css'
			)
		);
		
		unset($js);
		
		if ( $fcache->contains( $this -> _front ->getRouter() ->getController() ) === false ) {
			
			$css = \FMW\Utilities\Minify\CSSMin::minify( $this->_cssCache, $this->_front->getApp()->getConfig() );
			
			$fcache->save( $this -> _front ->getRouter() ->getController(), $css, $this->_cachetime );
				
		}
		
		unset($css);
	}
	
	/**
	 * 
	 * @param string $url
	 * @return mixed
	 */
	private function loadJsonFile($url) {
		
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
		
		$conf = $this->_front->getApp() ->getConfig();
		
		if ( $conf->appmode == 'development' && $conf->development->username ) {
			curl_setopt($ch, CURLOPT_USERPWD, "{$conf->development->username}:{$conf->development->password}");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		}
		
		$file_contents = curl_exec($ch);
		
		curl_close($ch);
		
		return json_decode($file_contents, true);
	}
}
