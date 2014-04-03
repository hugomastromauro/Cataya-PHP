<?php

namespace CATAYA\Controller;

use FMW\Utilities\Session\Session;

/**
 *
 * Classe ControllerPagina
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, Hugo Mastromauro da Silva.
 * @access public
 * @package ELEVE
 * @subpackage controllers
 *
 */
class ControllerPagina
	extends \FMW\Controller\AController {
	
	/**
	 * 
	 * @var mixed
	 */
	protected $session;
	
	/**
	 * 
	 * @var string
	 */
	protected $layout;

	/**
     * Construtor padrão do controller
     * @method init
     * @access public
     * @return void
     */
	public function init () {
				
		/*
		 * Configuração da Sessão
		 */
		$this->session = new Session( array('timeout' => $conf->geral->sessao ) );
		
		/*
		 * Definindo e formatando o título
		 */
		$this->formatTitle( $this->app->getConfig()->hashtitle )
			->setTitle( $this->app->getConfig()->appname );

		/*
		 * Setando helpers
		 */
		$this->view->setHelper( 'helper', new \FMW\View\Helper\Helper() );
	}
	
	/**
	 * 
	 * Setando layout da página
	 * 
	 * @param string $layout
	 */
	protected function setLayout( $layout ) {
		$this->layout = $layout;
	}
	
	/**
	 * 
	 * Sobrescrevendo o metodo postActionEvent para renderizar o layout certo.
	 * (non-PHPdoc)
	 * @see FMW\Controller.AController::postActionEvent()
	 */
	public function postActionEvent( array $params ){
		
		if ( $this->layout )
			$this->view->layout( $this->layout );
		
		parent::postActionEvent($params);
		
		/*
		 * Verificar o tempo de execução da página
		 */
		\FMW\Utilities\Debugger\Tracking::end();
	}

	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.AController::errorAction()
	 */
	public function errorAction( array $params ) {
		
		/*
		 * Redireciona para a página 404 caso não exista!
		 */
		echo 'configurar a página 404!';
		
	}
}
