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
	 * @var FMW\Config
	 */
	private $_config;

	/**
	 *
	 * @var FMW\Application\Bootstrap\Abstract
	 */
	private $_bootstrap;

	/**
	 *
	 * @var array
	 */
	private $_objects = array();

	/**
	 * 
	 * @throws \Exception
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
	 * 
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
	 * 
	 * @return boolean
	 */
	public function isApache() {

		if (preg_match('/apache/i', $_SERVER['SERVER_SOFTWARE'])) {
			return true;
		}

		return false;
	}

	/**
	 * 
	 * @return \FMW\FMW\Config
	 */
	public function getConfig() {
		return $this ->_config;
	}
	
	/**
	 * 
	 * @return \FMW\FMW\Application\Bootstrap\Abstract
	 */
	public function getBootstrap() {
		return $this ->_bootstrap;
	}
}
