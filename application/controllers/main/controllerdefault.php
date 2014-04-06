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
		
		//\FMW\Utilities\Debugger\Tracking::start();
		
		$this->assets->loadPlugin( array( 'jquery', 'bootstrap' ) );
		
		$this->assets->setCss( 'website', array( 'app.css' ) );
		$this->assets->setJavascript( 'website', array( 'app.js' ) );
	}
	
	/**
     * Ação principal do controller
     * @method indexAction
     * @param array $params
     * @access public
     * @return void
     */
	public function indexAction( array $params ) {
		
		$this->setTitleCh( 'Home' );
				
		$this->view->layout('home');
	}
	
	/**
	 * 
	 * @method servicosAction
	 * @param array $params
	 * @access public
	 * @return void
	 */
	public function servicosAction( array $params ) {
		
		$this->setTitleCh( 'Serviços' );
		
		$this->view->layout('servicos');
	}
	
	/**
	 *
	 * @method contatoAction
	 * @param array $params
	 * @access public
	 * @return void
	 */
	public function contatoAction( array $params ) {
		
		$this->setTitleCh( 'Contato' );
		
		$this->view->layout('contato');
	}
	
	/**
	 *
	 * @method sobreAction
	 * @param array $params
	 * @access public
	 * @return void
	 */
	public function sobreAction( array $params ) {
	
		$this->setTitleCh( 'sobre' );
	
		$this->view->layout('quem-somos');
	}
	
	/**
	 *
	 * Página 404
	 * 
	 * @method errorAction
	 * @param array $params
	 * @access public
	 * @return void
	 */
	public function errorAction( array $params ) {
	
		$this->setTitleCh( '404' );
	
		$this->view->layout('404');
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