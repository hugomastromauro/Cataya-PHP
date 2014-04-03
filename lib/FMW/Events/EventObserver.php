<?php

namespace FMW\Events;

/** 
 * 
 * Class EventObserver
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class EventObserver {
		
	/**
	 * Array of hooks
	 */
	private $aHooks = array ();
	
	/**
	 * Constructor
	 */
	public function __construct() {
	
	}
	
	/**
	 * Bind functionality
	 * @param string $sEvent	the name of the event to bind
	 * @param object &$oObj    	the object whose method we wish to call
	 * @param string $sMethod 	the method to call
	 * @param string $sArgs
	 */
	public function bind($sClass, $sEvent, &$oObj, $sMethod, $sArgs) {		
		$this->aHooks [$sClass][$sEvent] [] = new \FMW\Events\EventBinding ( $oObj, $sClass, $sMethod, $sArgs );	
	}
	
	/**
	 * 
	 */
	public function getHooks() {
		return $this->aHooks;
	}
	
	/**
	 * Trigger a bound event
	 * @param string $sEvent    the event to trigger
	 * @param array  $aArgs     an array of arguments to pass to the bound function
	 */
	public function trigger($sClass, $sEvent, $aArgs = array()) {
		if (array_key_exists ( $sClass, $this->aHooks ) && array_key_exists ( $sEvent, $this->aHooks [$sClass] )) {			
			foreach ( $this->aHooks [$sClass][$sEvent] as $key => $Binding ) {				
				$Binding->trigger ( $aArgs );
			}
		}
	}
}