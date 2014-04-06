<?php

namespace CATAYA\Controller;

use FMW\Utilities\Session\Session;

/**
 *
 * Classe ControllerPagina
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Controller
 * @subpackage CATAYA
 *
 */
class ControllerPagina
	extends \FMW\Controller\AController {
	
	/**
	 * 
	 * @var \FMW\Utilities\Session\Session
	 */
	protected $session;
	
	/**
	 * 
	 * @var string
	 */
	protected $layout;

	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\AController::init()
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
	 * @param string $layout
	 */
	protected function setLayout( $layout ) {
		$this->layout = $layout;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\AController::postActionEvent()
	 */
	public function postActionEvent( array $params ){
		
		if ( $this->layout )
			$this->view->layout( $this->layout );
		
		parent::postActionEvent($params);
		
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
