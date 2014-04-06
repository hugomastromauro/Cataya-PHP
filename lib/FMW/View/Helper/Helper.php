<?php

namespace FMW\View\Helper;

use FMW\Utilities\String\String;

/** 
 * 
 * Classe Helper
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Helper 
 * @subpackage View
 *  
 */ 
class Helper
	extends \FMW\View\Helper\AHelper {
		
	/**
	 * 
	 * @param string $module
	 * @return string
	 */
	public function url( $module = 'default' ) {

		$args = func_get_args();
		$query = '';
		$params = ''; 
		
		for ($i = 1; $i < count($args); $i++){
			
			if (preg_match('/\?/', $args[$i])) {
				$query = $args[$i];
			} else {
			
				if (is_string($args[$i])) {
					$args[$i] = String::seo($args[$i]);
				}
				$params .= isset($args[$i]) ? $args[$i] . '/' : '';
			}
		}
				
		return $this->_view->baseurl . $module . '/' . $params . $query;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function fullurl() {
		return "http://{$_SERVER[HTTP_HOST]}{$_SERVER[REQUEST_URI]}";
	}
	
	/**
	 * 
	 * @param string $module
	 * @return string
	 */
	public function getBaseasset( $module ) {
		
		return $this->_config->baseurl . 'public/' .
					 $module . '/assets/';
	}
	
	/**
	 * 
	 * @return string
	 */
	public function meta() {
		
		$html = '';
		
		if ($this->_view->meta) {
			foreach($this->_view->meta as $name => $content) {
		    	$html .= '<meta name="' . $name . '" content="' . $content . '">';
			}
		}
		
		return $html;
	}
	
	/**
	 * 
	 * @param string $command
	 * @param string $params
	 * @return Ambigous <\FMW\Router\multitype:, multitype:>|mixed|number|string
	 */
	public function router( $command, $params = null ) {
		
		switch ($command) {
			case 'method':
				return $this->_router->getMethod();
				break;
			case 'controller':
				return preg_replace('/controller/i', '', $this->_router->getController());
				break;
			case 'params':
				return $this->_router->getParam( $params );
				break;
			case 'segments':
				return $this->_router->segments();
				break;
			case 'segment':
				return $this->_router->segment( $params );
				break;
			case 'query':
				return $this->_router->getQuerystring();
				break;
			case 'module':
				return rtrim($this->_router->getModule(), '\\');
				break;
			case 'url':
				return $this->_router->getFullUrl();
				break;
		}
	}
}
