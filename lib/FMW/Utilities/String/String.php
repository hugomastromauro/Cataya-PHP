<?php

namespace FMW\Utilities\String;

/** 
 * 
 * Class Session
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */  
class String
	extends \FMW\Object {
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $text
	 * @param int $length
	 * @param string $tail
	 */
	public static function snippet($text, $length=64, $tail="...") {

		$text = trim($text);
	    $txtl = strlen($text);
	    
	    if($txtl > $length) {
	        for($i=1;$text[$length-$i]!=" ";$i++) {
	            if($i == $length) {
	                return substr($text,0,$length) . $tail;
	            }
	        }
	        $text = substr($text, 0, $length-$i+1) . $tail;
	    }
	    return $text;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $text
	 * @param int $length
	 * @param string $tail
	 */
	public static function snippetgreedy($text, $length=64, $tail="...") {
	    $text = trim($text);
	    if(strlen($text) > $length) {
	        for($i=0;$text[$length+$i]!=" ";$i++) {
	            if(!$text[$length+$i]) {
	                return $text;
	            }
	        }
	        $text = substr($text,0,$length+$i) . $tail;
	    }
	    return $text;
	}

	/**
	 * 
	 * Enter description here ...
	 * @param string $text
	 * @param int $length
	 * @param string $tail
	 */
	public static function snippetwop($text, $length=64, $tail="...") {
		
	    $text = trim($text);
	    $txtl = strlen($text);
	    if($txtl > $length) {
	        for($i=1;$text[$length-$i]!=" ";$i++) {
	            if($i == $length) {
	                return substr($text, 0, $length) . $tail;
	            }
	        }
	        for(;$text[$length-$i]=="," || $text[$length-$i]=="." || $text[$length-$i]==" ";$i++) {;}
	        $text = substr($text,0,$length-$i+1) . $tail;
	    }
	    return $text;
	}
	
	/**
	 * Este é o correto!
	 * Remover acentos
	 * @param string $string
	 */
	public static function normalize($string, $enc = "UTF-8") {
		
		$string = html_entity_decode($string, ENT_QUOTES, $enc);
		
		$non = array(
			'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
			'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
			'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
			'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
			'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
			'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
			'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
			'ÿ'=>'y', 'R'=>'R', 'r'=>'r'
		);
		
		return strtr(htmlspecialchars($string, ENT_NOQUOTES, $enc), $non);
	}
	
	/**
	 * 
	 * Redefinir string para url
	 * @param string $string
	 */
	public static function seo($string, $enc = "UTF-8") {
		    	    	
    	$string = String::normalize($string, $enc);    			
		return preg_replace('/[^a-z0-9_-]/i', '', strtolower(str_replace(' ', '-', trim($string))));
    }
}