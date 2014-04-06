<?php

/** 
 * Cataya-PHP
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
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