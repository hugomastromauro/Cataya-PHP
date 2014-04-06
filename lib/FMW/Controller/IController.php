<?php

namespace FMW\Controller;

/** 
 * 
 * Interface de Classe Controller
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Controller 
 * @subpackage FMW
 *  
 */ 
interface IController {	
	
	/** 
     * Construtor do controller
     * 
     * @method init
     * @param array $pagina
     * @access public     
     * @return void 
     */ 
	public function init();
	
	/** 
     * Ação principal
     * 
     * @method indexAction
     * @param array $pagina
     * @access public     
     * @return void 
     */
	public function indexAction( array $params );

	/** 
     * Pré ação do controller
     * 
     * @method preActionEvent
     * @param array $pagina
     * @access public     
     * @return void 
     */
	public function preActionEvent( array $params );
	
	/** 
     * Pós ação do controller
     * 
     * @method posActionEvent
     * @param array $pagina
     * @access public     
     * @return void 
     */
	public function postActionEvent( array $params );
	
	/** 
     * Metodo padrão de retorno de erro
     * 
     * @method errorAction
     * @param array $pagina
     * @access public     
     * @return void 
     */
	public function errorAction( array $params );
}
