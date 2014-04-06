<?php

namespace controllers\main;

use FMW\Utilities\Validation\Validation,
	FMW\Utilities\Validation\Net\Net,
	FMW\Utilities\Mail\Mail;

/**
 * Classe ControllerContato
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright GPL © 2014, catayaphp.com.
 * @access public
 * @package main
 * @subpackage controllers
 */
class ControllerContato
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
		
		$this->setTitleCh( 'Contato' );
	}
	
	/**
     * Ação principal do controller
     * @method indexAction
     * @param array $params
     * @access public
     * @return void
     */
	public function indexAction( array $params ) {
		
		$this->view->layout('contato');
	}
	
	/**
	 * 
	 * @method enviarAction
	 * @param array $params
	 * @access public
	 * @return void
	 */
	public function enviarAction(array $params) {
	
		$rules = array(
			'nome' =>
				array(
					'label' => 'Nome',
					'rules' => 'required'
			),
	
			'telefone' =>
				array(
					'label' => 'Telefone',
					'rules' => 'required'
			),
	
			'email' =>
				array(
					'label' => 'E-mail',
					'rules' => Net::validate('email')
			),
	
			'mensagem' =>
				array(
					'label' => 'Mensagem',
					'rules' => 'required'
			)
		);
			
		$messages = array('error' =>
			array(
				'required' => 'Obrigatório o preenchimento do campo %s!',
				'Net:email' => 'Email inválido!'
			)
		);
			
		$vl = new Validation( $rules, $messages );
	
		if ( $vl->validate() ) {
	
			$mail = new Mail(array(
					'from' 		=> $this->request->email,
					'to' 		=> $this ->front ->getApp() ->getConfig()->geral->email,
					'subject'	=> 'Contato',
					'template'	=> $this ->front ->getApp() ->getConfig() ->controller ->module ->path .
										\FMW\Utilities\File\Util::rslash( $this ->front ->getRouter() ->getModule() ) .
											'layout/template_email_contato.html'
				)
			);
				
			$mail->baseasset = $this->view->baseasset;
			$mail->nome = $this->request->nome;
			$mail->email = $this->request->email;
			$mail->telefone = $this->request->telefone;
			$mail->mensagem = $this->request->mensagem;
			
			if ($mail->send()) {
				
				$vl->setError('Formulário enviado com sucesso!', 'success', 'Email', 'sucesso');
				
			} else {
				
				$vl->setError('Não foi possível enviar o formulário neste momento.', 'error', 'Email', 'error');
			}
		} 
		
		$this->view->data = $vl->getAllData();
		$this->view->error = $vl->getAllError();
		
		$this->view->layout('contato');
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