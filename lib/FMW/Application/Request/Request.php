<?php

namespace FMW\Application\Request;

use FMW\Utilities\Filters\Filter;

/**
 *
 * Classe Request
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Request
 * @subpackage Application
 *
 */
class Request
	extends \FMW\Object {

	/**
	 * 
	 * @var \FMW\Utilities\Filters\Filter
	 */
	private $filter;
	
	/**
	 * 
	 * @var array
	 */
	private $headers;

	/**
	 * 
	 * @param array $request
	 */
	public function __construct( array $request ) {
		
		$this->filter = new Filter();
		
		$parse = array();
		parse_str( file_get_contents('php://input'), $parse );
		
		$this->setArray( $this->filter->sanitize( array_merge( $parse, $request, $_REQUEST ) ) );
		
		$this->headers = $this->parseRequestHeaders();
		
	}
	
	/**
	 * 
	 * @return multitype:unknown
	 */
	private function parseRequestHeaders() {
		
		$headers = array();
		foreach($_SERVER as $key => $value) {
			if (substr($key, 0, 5) == 'HTTP_') {
				continue;
			}
			$header = str_replace('HTTP-', '', $key);
			$headers[$header] = $value;
		}
		return $headers;
	}
	
	/**
	 * 
	 * @param string $key
	 * @return multitype:
	 */
	public function getHeader( $key ) {
		return $this->headers[$key];
	}
}
