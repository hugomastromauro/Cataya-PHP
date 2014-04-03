<?php

namespace FMW\Controller;

/** 
 * 
 * Interface Class Controller
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
interface IController {	
	
	/** 
     * Construtor do controller
     * @method init
     * @param array $pagina
     * @access public     
     * @return void 
     */ 
	public function init();
	
	/** 
     * Ação principal
     * @method indexAction
     * @param array $pagina
     * @access public     
     * @return void 
     */
	public function indexAction( array $params );

	/** 
     * Pré ação do controller
     * @method preActionEvent
     * @param array $pagina
     * @access public     
     * @return void 
     */
	public function preActionEvent( array $params );
	
	/** 
     * Pós ação do controller
     * @method posActionEvent
     * @param array $pagina
     * @access public     
     * @return void 
     */
	public function postActionEvent( array $params );
	
	/** 
     * Metodo padrão de retorno de erro
     * @method errorAction
     * @param array $pagina
     * @access public     
     * @return void 
     */
	public function errorAction( array $params );
}
