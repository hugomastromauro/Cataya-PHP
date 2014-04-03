<?php

namespace FMW;


interface iObject
{
    /**
     * 
     * Enter description here ...
     * @param $string $name
     * @param array $arguments
     */
    public function __call($name, array $arguments);
    
    /**
     * 
     * Enter description here ...
     * @param string $key
     */
    public function stack($key = NULL);
    
}