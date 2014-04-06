<?php

namespace FMW\Utilities\Cache;

use DoctrineExtensions\Versionable\Exception;

use \Memcache;

/** 
 * 
 * Classe MemcacheCache
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Cache 
 * @subpackage Utilities
 *  
 */ 
class MemcacheCache 
	extends ACache {
	
	/**
	 * 
	 * @var Memcached
	 */
	private $_instance;
	
	/**
	 * 
	 * @var bool
	 */
	private $_compressed = false;
	
	/**
	 * 
	 * @param array $params
	 * @throws Exception
	 */
	public function __construct( array $params ) {
		
		if ( ! isset( $params['server'] ) ) throw new Exception('Servidores não definidos!');
		if ( isset( $params['compressed'] ) && !is_bool($params['compressed'])) throw new Exception('Parâmetros incorretos!') || $this->_compressed = $params['compressed'];
		
		$this->_instance = new Memcache();
		
		if (is_array($params['server'])) {
			foreach($params['server'] as $key => $value) {
				 $this->_instance->addServer($value['host'], $value['port']);
			}
		}else{
			$this->_instance->addServer($params['server']['host'], $params['server']['port']);
		}
	}
	
	/**
	 * 
	 * @param string $id
	 * @return boolean
	 */
	protected function _doContains($id) {
		
		if ($this->_instance->get($id))
			return true;
		
		return false;
	}
	
	/**
	 * 
	 * @param string $id
	 */
	public function _doDelete($id) {
	
		if ($this->_doContains($id))
			return $this->_instance->delete($id);
	}
	
	/**
	 * 
	 * @param string $id
	 */
	public function _doFetch($id) {
		
		if ($this->_doContains($id)) 
			return $this->_instance->get($id);
	}
	
	/**
	 * 
	 */
	public function flush() {
		return $this->_instance->flush();
	}
	
	/**
	 * 
	 * @param string $id
	 * @param mixed $value
	 * @param int $lifetime
	 */
	protected function _doSave($id, $value, $lifetime) {
		
		if ($this->_doContains($id)) {
			$this->_instance->replace($id, $value, false, $lifetime);
		} else {
			$this->_instance->add($id, $value, false, $lifetime);
		}	
	}
}