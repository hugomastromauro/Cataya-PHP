<?php

namespace CATAYA\Controller;

use	FMW\Utilities\Cache\MemcacheCache,
	FMW\Utilities\Session\Session;

/**
 *
 * Classe ControllerServices
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, Hugo Mastromauro da Silva.
 * @access public
 * @package ELEVE
 * @subpackage controllers
 *
 */
class ControllerServices
	extends \FMW\Controller\AControllerServices {
	
	/**
	 * 
	 * @var mixed
	 */
	protected $session;
	
	/**
	 * 
	 * @var array
	 */
	protected $params;
	
	/**
	 *
	 * @var \FMW\Utilities\Cache\MemcacheCache
	 */
	protected $memcache;

	/**
     * Construtor padrão do controller
     * @method init
     * @access public
     * @return void
     */
	public function init () {
		
		/*
		 * Setando o cache
		 */
		$this->memcache = new MemcacheCache(array(
				'server' => array(
					array('host' => $this ->front ->getApp() ->getConfig()->memcache->server, 'port' => $this ->front ->getApp() ->getConfig()->memcache->port)
				),
				'namespace' => $this ->front ->getApp() ->getConfig() ->appname
			)
		);
		
		/*
		 * Setando configurações
		*/
		$conf = $this->configuracoes();
		
		/*
		 * Configuração da Sessão
		*/
		$this->session = new Session( array('timeout' => $conf->geral->sessao ) );

	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IControllerServices::getAction()
	 */
	public function getAction( array $params ) {
		
		$this->setStatusHeader( 400 );
		$this->result = 'Serviço não disponível!';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IControllerServices::postAction()
	 */
	public function postAction( array $params ) {
		
		$this->setStatusHeader( 400 );
		$this->result = 'Serviço não disponível!';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IControllerServices::updateAction()
	 */
	public function updateAction( array $params ) {
		
		$this->setStatusHeader( 400 );
		$this->result = 'Serviço não disponível!';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Controller.IControllerServices::deleteAction()
	 */
	public function deleteAction( array $params ) {
		
		$this->setStatusHeader( 400 );
		$this->result = 'Serviço não disponível!';
	}
	
	/**
	 * Autenticando usuário
	 * 
	 * (non-PHPdoc)
	 * @see \FMW\Controller\AControllerServices::authentication()
	 */
	public function authentication() {

		if (!$this->request->chave && !$this->request->dominio) {
			
			$this->setStatusHeader( 400 );
			$this->error = 'Não autênticado!';
			
			return false;
			
		} else {
			
			$auth = $this->entityManager->getRepository('models\Aplicacoes')
						->selectByChaveAndDominio( $this->request->chave, $this->request->dominio );
			
			if ($auth) {
				
				$this->request->aplicacaoId = $auth['aplicacaoId'];
				$this->request->acao = 'serviço';
				$this->request->ip = $_SERVER['REMOTE_ADDR'];
				
				$this->entityManager->getRepository('models\AplicacoesAcessos')
					->insert( $this->request );
						
				return true;
				
			} else {
				
				$this->setStatusHeader( 400 );
				$this->error = 'Não autênticado!';
				
				return false;
			}
		}
	}
	
	/**
	 * Carregando informações de configuração
	 *
	 * @param int $paginaId
	 */
	private function configuracoes( $paginaId = 0 ) {
	
		if ( $this->memcache->contains( $this->app->getConfig()->appname . '_configuracao_pagina_' . $paginaId )) {
				
			$this->app->getConfig()->setArray( $this->memcache->fetch( $this->app->getConfig()->appname . '_configuracao_pagina_' . $paginaId ) );
				
		} else {
				
			$conf = $this->entityManager->getRepository('models\Configuracao')
						->selectByPaginaId( $paginaId );
				
			$grupos = array();
				
			foreach($conf as $row) {
				if (isset($row['grupo'])) {
					$grupos[$row['grupo']][$row['nome']] = $row['valor'];
				}else{
					$this->app->getConfig()->$row['nome'] = $row['valor'];
				}
			}
				
			$this->app->getConfig()->setArray($grupos);
			$this->memcache->save( $this->app->getConfig()->appname . '_configuracao_pagina_' . $paginaId, $grupos, $conf->geral->cache );
				
			unset($conf);
		}
	
		return $this->app->getConfig();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Controller\AControllerServices::preActionEvent()
	 */
	public function preActionEvent( array $params) {
		
		parent::preActionEvent($params);
		
		$this->setMIMEType();
	}
}