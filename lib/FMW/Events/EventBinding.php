<?php

namespace FMW\Events;

/** 
 * 
 * Class EventBinding
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class EventBinding {
	
	/**
	 * 
	 * Enter description here ...
	 * @var object
	 */
	private $oObj;
	
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $sMethod;
	
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $sClass;
	
	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	private $sArgs;
	
	/**
	 * Constructor
	 * @param object &$oObj the object on which we wish to call a method, passed by referenct
	 * @param string $sClass
	 * @param string $sMethod the method to call
	 * @param array $sArgs
	 */
	public function __construct(&$oObj, $sClass, $sMethod, $sArgs = array()) {
		$this->oObj = $oObj;
		$this->sClass = $sClass;
		$this->sMethod = $sMethod;		
		$this->sArgs = $sArgs;
	}
	
	/**
	 * Trigger the event
	 * @param $aArgs an array of arguments for the bound function
	 */
	public function trigger($aArgs = array()) {
		$aArgs = empty($aArgs) ? $this->sArgs : $aArgs;
		return call_user_func_array ( array ($this->oObj, $this->sMethod ), $aArgs );
	}
	
	/**
	 * Método que retorna o objeto atual
	 * @access public
	 * @return object
	 */
	public function getObj(){
		return $this->oObj;
	}
	
	/**
	 * Método que retorna o método do objeto atual
	 * @access public
	 * @return string
	 */
	public function getMethod(){
		return $this->sMethod;
	}
	
	/**
	 *
	 * Método que retorna o nome da classe
	 * @access public
	 * @return string
	 */
	public function getClass() {
		return $this->sClass;	
	}
}