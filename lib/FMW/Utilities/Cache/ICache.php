<?php

namespace FMW\Utilities\Cache;

/** 
 * 
 * Interface de Classe ICache
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Cache 
 * @subpackage Utilities
 *  
 */ 
Interface ICache {
	
	/**
	 * 
	 * @param string $id
	 */
	public function fetch($id);

    /**
     * 
     * @param string $id
     */
    public function contains($id);
    
    /**
     *
     * @param string $id
     */
    public function delete($id);
    
	/**
	 * 
	 * @param string $id
	 * @param mixed $value
	 * @param int $lifeTime
	 */
	public function save($id, $value, $lifeTime = 0);

	/**
	 * 
	 * @param string $id
	 */
	public function cacheTime($id);
}