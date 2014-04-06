<?php

namespace FMW\Utilities\Session;

/**
 *
 * Classe Session
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Session
 * @subpackage Utilities
 *
 */
class Session
	extends \FMW\Object {

	/**
	 * 
	 * @param array $params
	 */
	public function __construct( array $params = null ) {
				
		if ( ! isset( $_SESSION ) )
			$this->sessionStart( $params );
		
		if (isset($_SESSION['CATAYA'])) {
			foreach( $_SESSION['CATAYA'] as $name => $value ) {
				$this->_data[$name] = $value;
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Object::set()
	 */
	public function set($name, &$value) {
	
		$this->_data[$name] = $value;
		$this->_count = count($this->_data);
		
		$this->save();
	}

	/**
	 * 
	 * @param string $name
	 */
	public function remove($name) {
		
		if (isset($this->_data[$name]))
				unset($this->_data[$name]);
		
		$this->save();
	}
	
	/**
	 *
	 */
	public function save() {
		$_SESSION['CATAYA'] = $this->_data;
	}

	/**
	 * 
	 */
	public function destruct() {
		$this->_data = null;
		$this->save();
	}

	/**
	 * 
	 * @param array $params
	 */
	private function sessionStart( array $params = null ) {

		$timeout = isset($params['timeout']) ? $params['timeout'] : 5;
		$probability = isset($params['probability']) ? $params['probability'] : 100;
		$cookie_domain = isset($params['cookiedomain']) ? $params['cookiedomain'] : '/';

	    ini_set("session.gc_maxlifetime", $timeout);
	    ini_set("session.cookie_lifetime", $timeout);

	    ini_set("session.gc_probability", $probability);
	    ini_set("session.gc_divisor", 100);

	    session_start();
	    
	    if ( isset( $_COOKIE[session_name()] ) ) {
	        setcookie(session_name(), $_COOKIE[session_name()], time() + $timeout, $cookie_domain);
	    }
	}
}