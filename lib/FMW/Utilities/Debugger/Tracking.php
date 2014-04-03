<?php

namespace FMW\Utilities\Debugger;

/** 
 * 
 * Classe Tracking
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, Hugo Mastromauro. 
 * @access public  
 * @package FMW 
 * @subpackage controllers
 *  
 */ 
class Tracking 
	extends Debug {
	
	/**
	 * 
	 * @var object
	 */
	public static $runstart;
	
	/**
	 * 
	 * @param string $index
	 * @return number
	 */
	private function runtime( $index ) {
		
		$ruend = getrusage();
		
	    return ($ruend["ru_$index.tv_sec"]*1000 + intval($ruend["ru_$index.tv_usec"]/1000))
	     -  (self::$runstart["ru_$index.tv_sec"]*1000 + intval(self::$runstart["ru_$index.tv_usec"]/1000));
	    
	}
	
	/**
	 * 
	 */
	public static function start() {
		
		self::$runstart = getrusage();
	} 
	
	/**
	 * 
	 */
	public static function end() {
		
		if (self::$runstart) {
			
			parent::logScreen( array(
					'process' 	=> 'Este processo utilizou ' . self::runtime('utime') / 1000 . 's para ser executado.',
					'spent'		=> 'Foi utilizado ' . self::runtime('stime') / 1000 . 's para chamadas no sistema.',
					'memory'	=> 'Consumo de memória ' . Round(memory_get_usage( true ) / 1024 / 1024, 2) . ' MB'
				),
				'tracking' 
			);
			
		}
	}
}