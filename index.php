<?php

/** 
 * Framework FMW
 * 
 * index
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 *  
 */
   	
defined('APPLICATION_LIB')
	|| define('APPLICATION_LIB', realpath(dirname(__FILE__) . '/lib/'));

set_include_path(implode(PATH_SEPARATOR, array(

    		APPLICATION_LIB,
    		get_include_path(),
    		
		)
	)
);

include 'lib/FMW/Application.php';

$app = new \FMW\Application();

$app->bootstrap()->run();