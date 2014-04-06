<?php

namespace FMW;

/**
 *
 * Classe Application
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package FMW
 * @subpackage lib
 *
 */
class Application {

	/**
	 *
	 * Enter description here ...
	 * @var FMW\Config
	 */
	private $_config;

	/**
	 *
	 * Enter description here ...
	 * @var FMW\Application\Bootstrap\Abstract
	 */
	private $_bootstrap;

	/**
	 *
	 * Instâncias de objetos retornados pelo eventDispatch
	 * @var array
	 */
	private $_objects = array();

	/**
     * Construtor da classe
     * @access public
     * @return void
     */
	public function __construct() {
		
		$config = '';
		
		require_once 'Loader/ClassRegister.php';
		
		/**
		 * Checar consistência do arquivo
		 */
		foreach (glob(dirname(__FILE__) . '/../../' . '/application/config/*.php') as $filename)
		{
			require_once $filename;
		}

		$classLoader = new \FMW\Loader\ClassRegister('FMW', APPLICATION_LIB);
		$classLoader->register();

		if (!$config['apppath'])
			throw new \Exception( 'Diretório do aplicativo não específicado!' ); 
			
		$classLoader = new \FMW\Loader\ClassRegister('controllers', $config['apppath']);
		$classLoader->register();

		$this ->_config = \FMW\Loader\Loader::getInstance()
							->loadClass( 'FMW\Config',
								array( $config ) );
	}

	/**
	 * Método que instância o bootstrap atual
	 * 
	 * @access public
	 * @return \FMW\FMW\Application\Bootstrap\Abstract
	 */
	public function bootstrap() {

		if (file_exists($this->_config->apppath . '/Bootstrap.php')) {
			
			require_once $this->_config->apppath . '/Bootstrap.php';
			
			$this ->_bootstrap = \FMW\Loader\Loader::getInstance()
									->loadClass( 'Bootstrap',
										array( $this ) );
		} else {

			$this ->_bootstrap = \FMW\Loader\Loader::getInstance()
									->loadClass( 'Application\Bootstrap\Bootstrap',
										array( $this ) );
		}
				
		return $this ->_bootstrap;
	}

	/**
	 * Método que verifica se a aplicação está rodando em ambiente linux ou não
	 * 
	 * @access public 
	 * @return boolean
	 */
	public function isApache() {

		if (preg_match('/apache/i', $_SERVER['SERVER_SOFTWARE'])) {
			return true;
		}

		return false;
	}

	/**
	 * Método que retorna as configurações
	 * 
	 * @access public
	 * @return FMW_Config
	 */
	public function getConfig() {
		return $this ->_config;
	}
	
	/**
	 * Método que retorna o bootstrap da aplicação
	 * 
	 * @access public
	 * @return \FMW\FMW\Application\Bootstrap\Abstract
	 */
	public function getBootstrap() {
		return $this ->_bootstrap;
	}
}
