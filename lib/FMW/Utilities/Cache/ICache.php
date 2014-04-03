<?php

namespace FMW\Utilities\Cache;

/** 
 * 
 * Classe Cache
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
Interface ICache {
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $id
	 */
	public function fetch($id);

    /**
     * 
     * Enter description here ...
     * @param string $id
     */
    public function contains($id);
    
    /**
     *
     * Enter description here ...
     * @param string $id
     */
    public function delete($id);
    
	/**
	 * 
	 * Enter description here ...
	 * @param string $id
	 * @param mixed $value
	 * @param int $lifeTime
	 */
	public function save($id, $value, $lifeTime = 0);

	/**
	 * 
	 * Enter description here ...
	 * @param string $id
	 */
	public function cacheTime($id);
}