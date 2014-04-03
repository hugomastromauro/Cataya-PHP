<?php

namespace FMW\Application\Bootstrap;

/** 
 * 
 * Classe Abstrata ABootstrap
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
abstract class ABootstrap 
	extends \FMW\Object
		implements \FMW\Application\Bootstrap\IBootstrap {
	
	/**
	 * 
	 * Enter description here ...
	 * @var FMW\Application
	 */
	protected $app;	
	
	/**
	 * Método contrutor da Classe Bootstrap
	 * 
	 * @method __construct
	 * @access public
	 * @param FMW_Application $app
	 * @return void
	 */
	public function __construct( \FMW\Application $app ) {
		
		/*
		 * Referencia do objeto da aplicacao para propagacao na aplicacao
		 */
		$this->app = $app;	
		
		/*
		 * Chamando o objeto padrão
		 */
		parent::__construct();
	}

	/**
	 * Método que inicializa a aplicação
	 * 
	 * @method run
	 * @access public
	 * @return void
	 */
	public function run() {			
		
		/*
		 * Instanciando a classe frontcontroller e encaminhando a ela a instancia da aplicação.
		 * Aqui ela despacha os plugins e outros helpers da aplicaçao
		 * 
		 */
		$front = \FMW\Loader\Loader::getInstance() 
					->loadClass( 'FMW\Application\Frontcontroller\Frontcontroller', 
						array( $this ->app ) );
		
		/*
		 * Chamando o controller na classe frontcontroller.
		 * Depois de todos os despachos feitos, e feita a chamada ao controller da aplicacao
		 * 
		 */
		$front ->callController();
	}
	
	/**
	 * Método que inicializa e confirma as configurações.
	 * 
	 * @method initConfirmSettings
	 * @access public
	 * return void
	 */
	public function initConfirmSettings() {
				
		if (!isset($this ->app->getConfig() ->controller ->error))
			$this ->app->getConfig() ->controller ->error = 'controllererror';
			
		if (!isset($this ->app->getConfig() ->controller ->method))
			$this ->app->getConfig() ->controller ->method = 'indexaction';

		if (!isset($this ->app->getConfig() ->apppath))
			throw new \FMW\Application\Bootstrap\Exception('Diretório da aplicação não informado!');
			
		if (!isset($this ->app->getConfig() ->controller ->path))
			throw new \FMW\Application\Bootstrap\Exception('Diretório dos controllers não informado!');
		
	}
} 
