<?php

namespace controllers\main;

/**
 *
 * Classe ControllerPrincipal
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, Hugo Mastromauro.
 * @access public
 * @package FMW
 * @subpackage controllers
 *
 */
class ControllerDefault
	extends \CATAYA\Controller\ControllerPagina {

	
	/**
	 * (non-PHPdoc)
	 * @see CATAYA\Controller.ControllerPagina::init()
	 */
	public function init() {
		
		parent::init();
		
		$this->assets->loadPlugin( array( 'jquery', 'bootstrap' ) );
		
		$this->setTitleCh( 'Pagina exemplo' );
	}
	
	/**
     * Ação principal do controller
     * @method indexAction
     * @param array $params
     * @access public
     * @return void
     */
	public function indexAction( array $params ) {
		
		$this->view->layout('home');
	}
	
	/**
	 * Método sobrecarregado da classe AController que
	 * é executado antes da ação principal independente
	 * se é o indexAction ou não.
	 * @see FMW\Controller.AController::preActionEvent()
	 */
	public function preActionEvent( array $params) {

		parent::preActionEvent($params);

	}
}