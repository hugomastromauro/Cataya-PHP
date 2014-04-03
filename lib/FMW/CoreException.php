<?php

namespace FMW;

use Exception;

/** 
 * 
 * Classe CoreException
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class CoreException 
	extends Exception {
	
	/**      
     * Variável do último erro ocorrido
     * 
     * @access private 
     * @name $_previous
     * @var string 
     */
	private $_previous = null;
	
	/** 
     * Método construtor da classe que herda de Exception
     * 
     * @access public
     * @param string $msg
     * @param int $code
     * @param Exception $previous     
     * @return void 
     */
	public function __construct($msg = '', $code = 0, $filename, $lineno, \Doctrine\ORM\EntityManager $db = null, Exception $previous = null) {
		if (version_compare ( PHP_VERSION, '5.3.0', '<' )) {
			parent::__construct ( $msg, ( int ) $code );
			$this->_previous = $previous;
		} else {
			parent::__construct ( $msg, ( int ) $code, $previous );
		}
	}
	
	/** 
     * Método sobrescrito de Exception que carrega métodos
     * 
     * @access public
     * @param string $method
     * @param array $args     
     * @return null
     */
	public function __call($method, array $args) {
		if ('getprevious' == strtolower ( $method )) {
			return $this->_getPrevious ();
		}
		return null;
	}
	
	/** 
     * Método sobrescrito de Exception que retorna erro gerado
     * 
     * @access public     
     * @return string 
     */
	public function __toString() {
		if (version_compare ( PHP_VERSION, '5.3.0', '<' )) {
			if (null !== ($e = $this->getPrevious ())) {
				return $e->__toString () . "\n\nNext " . parent::__toString ();
			}
		}
		return parent::__toString ();
	}
	
	/** 
     * Método sobrescrito de Exception que retorna a última mensagem
     * 
     * @access public     
     * @return string 
     */
	protected function _getPrevious() {
		return $this->_previous;
	}
}