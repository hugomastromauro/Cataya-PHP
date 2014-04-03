<?php

namespace FMW\Utilities\Debugger;

/** 
 * 
 * Classe Debug
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, Hugo Mastromauro. 
 * @access public  
 * @package FMW 
 * @subpackage controllers
 *  
 */ 
class Debug {
	
	/**
	 * 
	 * @param string $data
	 */
	static function write( $data ) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
	
	/**
	 * 
	 * @param string $data
	 * @param string $name
	 */
	protected function logScreen( $data, $name = null ) {
		
		echo '<pre style="font-family: consolas, courier new; color: black; background-color: #fff; border: 1px solid red; width: 90%; margin: 6px auto;">';
		echo '<div style="padding: 10px; background-color: red; margin: 0; color: white; font-face: Arial; font-size: 16px; cursor: pointer;" onclick="toggle(this.nextSibling);">Console ' . strtolower($name) . '</div>';
		echo '<div style="padding: 20px; display: none">';
		
		if (is_array($data)) {
			$data = print_r($data, true);
			$data = preg_replace('/\[(.*)\]/', '<div style="font-weight: bold; display: inline">[\\1]</div>', $data);
		}
		
		echo $data;
		echo '</div></pre>';
		echo "
		<script type=\"text/javascript\">
		<!--
		    function toggle(e) {
		       if(e.style.display == 'block')
		          e.style.display = 'none';
		       else
		          e.style.display = 'block';
		    }
		//-->
		</script>";
	}
}