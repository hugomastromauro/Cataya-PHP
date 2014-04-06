<?php

namespace FMW\Utilities\Net;

/** 
 * 
 * Classe HTTPClient
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Net 
 * @subpackage Utilities
 *  
 */ 
class HTTPClient 
	extends \FMW\Object {	
	
	/**
	 * 
	 * @var string
	 */
	private $_baseurl;
	
	/**
	 * 
	 * @var array
	 */
	private $_headers = array(

			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported'
	);
		
	/**
	 * 
	 * @param array $params
	 * @throws Exception
	 */
	public function __construct( array $params ) {
		
		if ( !isset($params['baseurl']) || !isset($params['baseurl']) ) {
			throw new Exception ( "URL não informada!" );
		} 
		
		$this->_baseurl = $params['baseurl'];
	}
	
	/**
	 * 
	 * @param string $value
	 */
	public function setHeaderCh( $value ) {
		
		header('HTTP/1.1 ' . $value . ' ' . $this->_headers[$value]);
	}
	
	/**
	 * 
	 * @param string $value
	 * @return multitype:
	 */
	public function getHeaderCh( $value ) {
		
		if (array_search($value, $this->_headers)) {
			return $this->_headers[$value];
		}
	}
	
	/**
	 * 
	 * @param string $url
	 * @param number $time
	 */
	public function refresh( $url, $time = 30 ) {
		
		if (filter_var($url, FILTER_VALIDATE_URL))
				$url = $this->_baseurl . $url;
		
		header("Refresh: {$time}; url={$url}");
	}
	
	/**
	 * 
	 * @param string $url
	 * @param array $query
	 * @param string $moved
	 */
	public function redirect( $url, array $query = null, $moved = false ) {
		
		$url = $this->checkURL($url);
		
		if ($query)
			$url .= '?' . http_build_query($query);
		
		if ($moved) 
			header('HTTP/1.1 301 Moved Permanently');
		
		if (!headers_sent()) {
			header("Location: {$url}");
		}else{
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$url.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
			echo '</noscript>';
		}
		
		die;
	}
	
	/**
	 * 
	 * @param string $url
	 * @param array $params
	 */
	public function call( $url, array $params = array() ) {
		
		$handle = curl_init( $this->checkURL($url) );
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $params);
		curl_exec($handle);
	}
	
	/**
	 * 
	 * @param string $url
	 * @return Ambigous <\FMW\Utilities\String\mixed, mixed>
	 */
	public function seo( $url ) {
		return \FMW\Utilities\String\String::seo( $url );
	}
	
	/**
	 * 
	 * @param string $url
	 * @throws Exception
	 * @return string
	 */
	private function checkURL( $url ) {
		
		if (strpos($url, 'http://') > 0) {
			if (!filter_var($url, FILTER_VALIDATE_URL))
				throw new Exception('URL inválida!');
		}else{
			$url = $this->_baseurl . $url;
		}
		
		return $url;
	}
}