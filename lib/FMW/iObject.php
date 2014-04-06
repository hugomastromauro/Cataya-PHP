<?php

namespace FMW;

/**
 *
 * Interface de Classe iObject
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package FMW
 * @subpackage lib
 *
 */
interface iObject
{
    /**
     * 
     * 
     * @param $string $name
     * @param array $arguments
     */
    public function __call($name, array $arguments);
    
    /**
     * 
     * 
     * @param string $key
     */
    public function stack($key = NULL);
    
}