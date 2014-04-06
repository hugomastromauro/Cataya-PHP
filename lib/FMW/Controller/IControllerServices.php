<?php

namespace FMW\Controller;

/** 
 * 
 * Interface de Classe IControllerServices
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Controller 
 * @subpackage FMW
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
