<?php

namespace FMW\Utilities\Cache;

/** 
 * 
 * Class Cache
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class ACache 
	extends \FMW\Object
		implements ICache {
	
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $_namespace = null;
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $namespace
	 */
	public function setNamespace( $namespace ) {
		$this->_namespace = $namespace;
	}
	
	/**
	 *
	 * Enter description here ...
	 */
	public function getNamespace() {
		return $this->_namespace;
	}
    
	/**
	 * (non-PHPdoc)
	 * @see FMW\Utilities\Cache.ICache::fetch()
	 */
    public function fetch($id) {
        return $this->_doFetch($this->_getNamespacedId($id));
    }

	/**
	 * (non-PHPdoc)
	 * @see FMW\Utilities\Cache.ICache::contains()
	 */
    public function contains($id){
        return $this->_doContains($this->_getNamespacedId($id));
    }
    
    /**
     * (non-PHPdoc)
     * @see FMW\Utilities\Cache.ICache::delete()
     */
    public function delete($id){
    	return $this->_doDelete($this->_getNamespacedId($id));
    }
	
    /**
     * (non-PHPdoc)
     * @see FMW\Utilities\Cache.ICache::save()
     */
	public function save($id, $value, $lifetime = 0) {	
		return $this->_doSave($this->_getNamespacedId( $id ), $value, $lifetime);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Utilities\Cache.ICache::cacheTime()
	 */
	public function cacheTime($id) {
		return $this->_doCacheTime($id);
	}
	
	/**
     * Prefix the passed id with the configured namespace value
     *
     * @param string $id  The id to namespace
     * @return string $id The namespaced id
     */
    private function _getNamespacedId($id) {
        if ( ! $this->_namespace || strpos($id, $this->_namespace) === 0) {
            return $id;
        } else {
            return $this->_namespace . $id;
        }
    }
}
