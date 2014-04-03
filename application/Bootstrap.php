<?php

use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration,
    Doctrine\DBAL\Event\Listeners\MysqlSessionInit;

/**
 *
 * Classe Bootstrap
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, hugomastromauro.com.
 * @access public
 * @package controllers
 * @subpackage appication
 *
 */
class Bootstrap
	extends \FMW\Application\Bootstrap\Bootstrap {
	
	/**
	 * 
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	/**
	 * Método que inicializa mensagens do sistema
	 * @access public
	 * @return void
	 */
	public function initErrors() {
		
		if ($this->app->getConfig()->appmode == 'development') {
			error_reporting(E_ALL & ~E_NOTICE);
	    	ini_set('display_errors', true);
		}else{
			error_reporting(0);
			ini_set('display_errors', false);
		}
	}
	
	/**
	 * Método de configurações do servidor
	 * @access public
	 * @return void
	 */
	public function initSettings() {
		
		ini_set('max_execution_time', '100');
		ini_set('max_input_time', '100');		
		ini_set('memory_limit', '512M');
	}

	/**
	 * Método que inicializa a internacionalização
	 * @access public
	 * @return void
	 */
	public function initTimeZone() {
		date_default_timezone_set('America/Sao_Paulo');
	}

	/**
	 * Método que inicializa rotas
	 * @access public
	 * @return void
	 */
	public function initRoutes() {

		FMW\Loader\Loader::getInstance() ->loadClass( 'FMW\Router\Router',
			array(
				array(
					array('^/$' => '/main/default/index/')
				)
			)
		);
	}

	/**
	 * Método que inicializa as bibliotecas
	 * @access public
	 * @return void
	 */
	public function initExtraLibraries() {
		
		$classLoader = new FMW\Loader\ClassRegister('CATAYA', APPLICATION_LIB);
		$classLoader->register();
	}

	/**
	 * Método que inicializa a biblioteca Doctrine
	 * @access public
	 * @return void
	 */
	public function initDoctrine() {

		$classLoader = new FMW\Loader\ClassRegister('Doctrine', APPLICATION_LIB);
		$classLoader->register();

		$classLoader = new FMW\Loader\ClassRegister('Symfony', APPLICATION_LIB . DIRECTORY_SEPARATOR . 'Doctrine');
		$classLoader->register();
		
		$classLoader = new FMW\Loader\ClassRegister('DoctrineExtensions', APPLICATION_LIB . DIRECTORY_SEPARATOR . 'Doctrine');
		$classLoader->register();
		
		$classLoader = new FMW\Loader\ClassRegister('models', $this->app->getConfig()->apppath . DIRECTORY_SEPARATOR);
		$classLoader->register();

		$classLoader = new FMW\Loader\ClassRegister('proxies', $this->app->getConfig()->apppath . DIRECTORY_SEPARATOR . 'models');
		$classLoader->register();
		
		if ($this->app->getConfig()->appmode == 'development') {
		    $cache = new \Doctrine\Common\Cache\ArrayCache;
		} else {
		    $cache = new \Doctrine\Common\Cache\ApcCache;
		}
		
		$cache->setNamespace($this->app->getConfig()->appname);
		
		$config = new Configuration();
		$config->setMetadataCacheImpl($cache);
		
		Doctrine\Common\Annotations\AnnotationRegistry::registerFile("Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php");
		$reader = new Doctrine\Common\Annotations\AnnotationReader();
		$driverImpl = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($reader, array($this->app->getConfig()->doctrine->models));
		
		$config->setMetadataDriverImpl($driverImpl);
		$config->setQueryCacheImpl($cache);
		$config->setResultCacheImpl($cache);
		
		$config->setProxyDir($this->app->getConfig()->doctrine->proxies);
		$config->setProxyNamespace('proxies');
		
		$config->addCustomStringFunction('IF', 'DoctrineExtensions\Query\Mysql\IfElse');
		$config->addCustomStringFunction('GROUP_CONCAT', 'DoctrineExtensions\Query\Mysql\GroupConcat');
		$config->addCustomStringFunction('CONCAT_WS', 'DoctrineExtensions\Query\Mysql\ConcatWs');
		
		if ($this->app->getConfig()->appmode == 'development') {
		    $config->setAutoGenerateProxyClasses(true);
		} else {
		    $config->setAutoGenerateProxyClasses(false);
		}

		$connectionOptions = array(
			'host' => $this->app->getConfig()->doctrine->host,
			'unix_socket' => $this->app->getConfig()->doctrine->socket,
		    'driver' => $this->app->getConfig()->doctrine->driver,
		    'dbname' => $this->app->getConfig()->doctrine->dbname,
		    'user' => $this->app->getConfig()->doctrine->user,
		    'password' => $this->app->getConfig()->doctrine->password,
			'charset' => 'UTF8',
	        'driverOptions' => array(
	            'charset' => 'UTF8'
	        )
		);
		
		/*
		 * Removendo configurações de banco de dados em produção
		 *  
		 */
		if ($this->app->getConfig()->appmode == 'production') {
			$this->app->getConfig()->remove('doctrine');
		}
		
		$this->em = EntityManager::create($connectionOptions, $config);
		$this->em->getEventManager()->addEventSubscriber(new MysqlSessionInit('utf8', 'utf8_unicode_ci'));

		return $this->em;
	}
}
