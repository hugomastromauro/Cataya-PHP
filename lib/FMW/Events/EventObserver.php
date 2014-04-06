<?php

namespace FMW\Events;

/** 
 * 
 * Classe EventObserver
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2010, catayaphp.com. 
 * @access public  
 * @package Events 
 * @subpackage FMW
 *  
 */ 
class EventObserver {
		
	/**
	 * 
	 * @var array
	 */
	private $aHooks = array();
	
	/**
	 * 
	 */
	public function __construct() {}
	
	/**
	 * 
	 * @param string $sClass
	 * @param string $sEvent
	 * @param Object $oObj
	 * @param string $sMethod
	 * @param array $sArgs
	 */
	public function bind($sClass, $sEvent, &$oObj, $sMethod, $sArgs) {		
		$this->aHooks [$sClass][$sEvent] [] = new \FMW\Events\EventBinding ( $oObj, $sClass, $sMethod, $sArgs );	
	}
	
	/**
	 * 
	 * @return multitype:
	 */
	public function getHooks() {
		return $this->aHooks;
	}
	
	/**
	 * 
	 * @param string $sClass
	 * @param string $sEvent
	 * @param array $aArgs
	 */
	public function trigger($sClass, $sEvent, $aArgs = array()) {
		if (array_key_exists ( $sClass, $this->aHooks ) && array_key_exists ( $sEvent, $this->aHooks [$sClass] )) {			
			foreach ( $this->aHooks [$sClass][$sEvent] as $key => $Binding ) {				
				$Binding->trigger ( $aArgs );
			}
		}
	}
}