<?php

namespace FMW\Events;

/** 
 * 
 * Class EventBinding
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0 
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Events 
 * @subpackage FMW
 *  
 */ 
class EventBinding {
	
	/**
	 * 
	 * @var Object
	 */
	private $oObj;
	
	/**
	 * 
	 * @var string
	 */
	private $sMethod;
	
	/**
	 * 
	 * @var string
	 */
	private $sClass;
	
	/**
	 * 
	 * @var array
	 */
	private $sArgs;
	
	/**
	 * 
	 * @param Object $oObj
	 * @param string $sClass
	 * @param string $sMethod
	 * @param array $sArgs
	 */
	public function __construct(&$oObj, $sClass, $sMethod, $sArgs = array()) {
		$this->oObj = $oObj;
		$this->sClass = $sClass;
		$this->sMethod = $sMethod;		
		$this->sArgs = $sArgs;
	}
	
	/**
	 * 
	 * @param array $aArgs
	 * @return mixed
	 */
	public function trigger($aArgs = array()) {
		$aArgs = empty($aArgs) ? $this->sArgs : $aArgs;
		return call_user_func_array ( array ($this->oObj, $this->sMethod ), $aArgs );
	}
	
	/**
	 * 
	 * @return object
	 */
	public function getObj(){
		return $this->oObj;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getMethod(){
		return $this->sMethod;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getClass() {
		return $this->sClass;	
	}
}