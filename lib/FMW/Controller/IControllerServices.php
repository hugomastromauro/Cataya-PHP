<?php

namespace FMW\Controller;

/** 
 * 
 * Interface Class IControllerServices
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
interface IControllerServices {	
	
	/** 
	 * 
     * @method postAction
     * @access public     
     * @return void 
     */
	public function postAction( array $params );

	/** 
	 * 
     * @method getAction
     * @access public     
     * @return void 
     */
	public function getAction( array $params );
	
	/** 
	 * 
     * @method updateAction
     * @access public     
     * @return void 
     */
	public function updateAction( array $params );
	
	/** 
	 * 
     * @method deleteAction
     * @access public     
     * @return void 
     */
	public function deleteAction( array $params );
	
	/** 
	 * 
     * @method authenticate
     * @access public     
     * @return void 
     */
	public function authentication();
}
