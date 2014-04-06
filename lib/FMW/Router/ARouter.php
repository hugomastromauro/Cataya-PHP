<?php

namespace FMW\Router;

use FMW\Utilities\Filters\Filter;

/**
 *
 * Classe Abstrata ARouter
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Router
 * @subpackage FMW
 *
 */
abstract class ARouter
	implements \FMW\Router\IRouter {
			
	/**
	 * 
	 * @var \FMW\Utilities\Filters\Filter
	 */
	private $_filter;

	/**
	 * 
	 * @var array
	 */
	private $_uri = array ('module' => '', 'controller' => '', 'method' => '', 'params' => array());

	/**
	 * 
	 * @var \FMW\Config
	 */
	private $_config;

	/**
	 * 
	 * @var array
	 */
	private $_query = array();

	/**
	 * 
	 * @var array
	 */
	private $_routes = array();

	/**
	 *
	 * @var array
	 */
	private $_segments = array();
	
	/**
	 * 
	 * @var array
	 */
	private $_urlparsed = array();


	/**
	 * 
	 * @param array $params
	 */
	public function __construct( array $params = array() ) {

		$this->_filter = new Filter();
		
		$this ->_config = \FMW\Loader\Loader::getInstance()
							->getClass('FMW\Config');

		if ( count( $params ) > 0 ) $this->setRoutes( $params );
	}

	/**
	 * 
	 */
	public function route() {

		$controller = '';

		$this->_uri['module'] = $this->_config->controller->module->default . $this->_config->namespaceseparator;

		$uri = explode( '/', $this->parseRoutes() );
		
		if (count($uri) > 1) {
			
			$i = 1;

			do {

				$controller = 'controller' . $uri[$i];
				
				if ( is_file( $this->_config->controller->path . $controller . '.php' ) )
				{
					$this->_uri['controller'] = $controller;
					continue;
				}

				if ( is_dir( $this->_config->controller->path . DIRECTORY_SEPARATOR . $uri[$i] ) && !empty($uri[$i]) )
				{
					if ($i == 1) $this->_uri['module'] = '';

					$this->_uri['module'] .= $uri[$i];

					if (substr($this->_uri['module'], -1) != '\\')
						$this->_uri['module'] .= $this->_config->namespaceseparator;

					continue;
				}
						
				if ( is_file( $this->_config->controller->path . DIRECTORY_SEPARATOR .
						preg_replace('/\\\/', '/', $this->_uri['module']) . DIRECTORY_SEPARATOR . $controller .	'.php' ) 
						&& empty ( $this->_uri['controller'] ) )
				{
					$this->_uri['controller'] = $controller;
					continue;
				}

				if ( ! empty( $this->_uri['module'] ) && empty( $this->_uri['controller'] ) )
				{
					$this->_uri['controller'] = $this->_config->controller->default;
				}

				if ( ! empty( $this->_uri['method'] ) )
				{
					$this->_uri['params'][] = $this->_filter->sanitize( $uri[$i] );
					continue;
				}

				if ( ! empty( $this->_uri['controller'] ) &&
						! empty( $this->_uri['module'] ) )
								$this->_uri['method'] = $uri[$i];

			} while ( ++$i < count($uri) );
		}
		
		if ( empty( $this->_uri['controller'] ) ) {
			$this->_uri['controller'] = $this->_config->controller->default;
		}
		
		$this->parseQuery();
		
		$this->_segments = $uri;
	}

	/**
	 * 
	 * @param array $array
	 */
	public function setRoutes( array $array ) {

		$this->_routes = $array;
	}

	/**
	 * 
	 * @return mixed|Ambigous <string, mixed>
	 */
	private function parseRoutes() {
		
		$this->_urlparsed = $this->parseUrl($_SERVER['REQUEST_URI']);
		
		$baseurl = $this->parseUrl($this->_config->baseurl);
		$baseurl = $baseurl['path'] != '/' ? $baseurl['path'] : '';
		
		$uri = preg_replace('/('.preg_replace('/\//', '\/', $baseurl).')?(\/index.php)?/', '', $this->_urlparsed['path']);
		
		if (count($this->_routes) > 0) {
			
			foreach ($this->_routes as $routes){

				foreach ($routes as $fixed => $redirect) {

					$newuri = preg_replace('/\//', '\/', $fixed);
					
					if (preg_match_all("/{$newuri}/", $uri, $matches)) {
						
						return preg_replace("/{$newuri}/", $redirect, $uri);
					}
				}
			}
		}

		return $uri[0] != '/' ? '/' . $uri : $uri;
	}
	
	/**
	 * 
	 * @param string $url
	 * @param string $retempty
	 * @param string $parsequery
	 * @return multitype:
	 */
	private function parseUrl($url, $retempty = TRUE, $parsequery = FALSE) {
		
		$url_default = array( 
			"original" => "",
			"scheme" => "", 
			"host" => "", 
			"port" => "", 
			"user" => "", 
			"pass" => "",
			"isdirectory" => "",
			"path" => "",
			"dirname" => "",
			"basename" => "",
			"extension" => "",
			"fragment" => "",
			"query" => "" 
		);
		$qpos = strpos($url, '?'); 
		
		if (!empty($qpos)) {	
			$baseurl = substr($url, 0, $qpos);		
			$bits = @parse_url($baseurl);
	
			$bits['basename'] = @basename($bits['path']);	
			$bits['query'] = substr($url, $qpos+1);
		} else { 
			$bits = @parse_url($url);		
		}
		
		$bits = array_merge($url_default, $bits);
		if (strtolower($bits['scheme']) == 'mailto') {
			unset($bits['basename']);
		} else {
			$bits = array_merge($bits,pathinfo($bits['path']));
		}
		
		if (!empty($bits['path'])){
			if ($bits['path'][strlen($bits['path']) - 1] == '/'){
				$bits['isdirectory'] = "TRUE";
			} else { $bits['isdirectory'] = "FALSE";}
		}
		
		if ($bits['dirname'] == '\\') $bits['dirname'] = '/';
		$bits['original']=$url;
		
		if ($parsequery === TRUE) $bits = array_merge($bits, $this->parsequery($bits['query']));
		
		$bits = array_merge($url_default, $bits);
		
		if ($retempty === FALSE) $bits = array_filter($bits);
		
		return $bits;
	}

	/**
	 * 
	 */
	private function parseQuery() {

		$query = $this->_urlparsed['query'];
		
		if (preg_match('/\&/i', $query)) {

			$ps = preg_split('/\&/i', $query);

			foreach ( $ps as $value ) {
				$var = explode( '=', $value );
				$this->_query[$var[0]] = $this->_filter->sanitize( $var[1] );
			}
		}
	}

	/**
	 * 
	 * @param int $index
	 * @return multitype:
	 */
	public function segment( $index ) {
		return $this->_segments[$index];
	}

	/**
	 * 
	 * @return number
	 */
	public function segments() {
		return (int) count($this->_segments)-1;
	}

	/**
	 * 
	 * @return multitype:
	 */
	public function getRoutes() {
		return $this->_routes;
	}
	
	/**
	 * 
	 * @return multitype:
	 */
	public function getUri() {
		return $this->_uri;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getFullUrl() {
		return preg_replace('/controller/', '', $this->_uri['controller']) . 
					'/' . $this->_uri['method'] . 
					'/' . implode('/', $this->_uri['params']);
	}

	/**
	 * 
	 * @param string $value
	 */
	public function setModule( $value ) {
		$this->_uri['module'] = $value;
	}

	/**
	 * 
	 * @return multitype:
	 */
	public function getModule(){
		return $this->_uri['module'];
	}

	/**
	 * 
	 * @param string $value
	 */
	public function setMethod( $value ) {
		$this->_uri['method'] = $value;
	}

	/**
	 * 
	 * @return multitype:
	 */
	public function getMethod(){
		return $this->_uri['method'];
	}

	/**
	 * 
	 * @param string $value
	 */
	public function setController( $value ) {
		$this->_uri['controller'] = $value;
	}

	/**
	 * 
	 * @return multitype:
	 */
	public function getController() {
		return $this->_uri['controller'];
	}

	/**
	 * 
	 * @param array $value
	 */
	public function setParams( array $value ) {
		$this->_uri['params'] = $value;
	}

	/**
	 * 
	 * @return multitype:
	 */
	public function getParams() {
		return $this->_uri['params'];
	}
	
	/**
	 * 
	 * @param int $index
	 */
	public function getParam( $index ) {
		return $this->_uri['params'][$index];
	}

	/**
	 * 
	 * @return multitype:
	 */
	public function getQuerystring() {
		return $this->_query;
	}
}