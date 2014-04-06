<?php

namespace FMW\Application\Bootstrap;

/** 
 * 
 * Classe Abstrata ABootstrap
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Bootstrap 
 * @subpackage Application
 *  
 */ 
abstract class ABootstrap 
	extends \FMW\Object
		implements \FMW\Application\Bootstrap\IBootstrap {
	
	/**
	 * 
	 * @var \FMW\Application
	 */
	protected $app;	
	
	/**
	 * 
	 * @param \FMW\Application $app
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
	 * (non-PHPdoc)
	 * @see \FMW\Application\Bootstrap\IBootstrap::run()
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
	 * 
	 * @throws \FMW\Application\Bootstrap\Exception
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
