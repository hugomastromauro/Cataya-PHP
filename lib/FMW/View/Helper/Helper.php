<?php

namespace FMW\View\Helper;

use FMW\Utilities\String\String;

/** 
 * 
 * Class Helper
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */ 
class Helper
	extends \FMW\View\Helper\AHelper {
	
	/**
	 * 
	 * @param string $text
	 * @param integer $length
	 * @param string $tail
	 * @return string
	 */
	public function textReduce( $text, $length=64, $tail="..." ) {
		return String::snippet( $text, $length, $tail );
	}
	
	/**
	 * 
	 * @param string $string
	 * @return string
	 */
	public function clearText( $text ) {
		return String::normalize( $text );
	}
	
	/**
	 * 
	 * @param string $module
	 * @return string
	 */
	public function url( $module = 'default' ) {
	
		$args = func_get_args();
		$query = '';
		$params = ''; 
		
		for ($i = 1; $i < count($args); $i++){
			
			if (preg_match('/\?/', $args[$i])) {
				$query = $args[$i];
			} else {
			
				if (is_string($args[$i])) {
					$args[$i] = String::seo($args[$i]);
				}
				$params .= isset($args[$i]) ? $args[$i] . '/' : '';
			}
		}
		return $this->_view->baseurl . $module . '/' . $params . $query;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function fullurl() {
		return "http://{$_SERVER[HTTP_HOST]}{$_SERVER[REQUEST_URI]}";
	}
	
	/**
	 * Return base asset by module
	 * 
	 * $this->helper->getBaseasset('main');
	 * 
	 * @param string $module
	 */
	public function getBaseasset( $module ) {
		
		return $this->_config->baseurl . 'public/' .
					 $module . '/assets/';
	}
	
	/**
	 * 
	 * @param string $email
	 * @return string
	 */
	public function obfuscateEmail( $email ) {
		
		$obs = "";
		for ($i=0; $i<strlen($email); $i++){
			$obs .= "&#" . ord($email[$i]) . ";";
		}
		
		return $obs;
	}
	
	/**
	 * 
	 * @param boolean $bool
	 * @return string
	 */
	public function boolSwitch( $bool ) {
		if ($bool) {
			return 'Sim';
		}
		return 'Não';
	}
	
	/**
	 * 
	 */
	public function meta() {
		
		$html = '';
		
		if ($this->_view->meta) {
			foreach($this->_view->meta as $name => $content) {
		    	$html .= '<meta name="' . $name . '" content="' . $content . '">';
			}
		}
		
		return $html;
	}
	
	/**
	 * 
	 * @param string $name
	 * @return string
	 */
	public function simpleData( $name, $value = null ) {
		return $this->_view->data[$name] ? isset($value) ? $value : $this->_view->data[$name] : '';
	}
	
	/**
	 * 
	 * @param string $module
	 * @return array
	 */
	public function showLayouts( $module = 'main' ) {
		
		$files = array();
		
		$handle = opendir($this->_config->controller->module->path . $module . '/layout/');
		
		if ($handle) {
			
			while (false !== ($entry = readdir($handle))) {
				
				$parts = preg_split('/\./', $entry);
				
				if ($parts[1] == 'php') 
					$files[$parts[0]] = $entry;
			}
			
			$entry = readdir($handle);
			
			while ($entry) {
				
				$parts = preg_split('/\./', $entry);
				
				if ($parts[1] == 'php') 
					$files[$parts[0]] = $entry;
			}	
		}
		
		closedir($handle);
		
		return $files;
	}
	
	/**
	 * 
	 * @param string $command
	 * @param array $params
	 * @return string|Ambigous <\FMW\Router\number, number>|\FMW\Router\multitype:|multitype:
	 */
	public function router( $command, $params = null ) {
		
		switch ($command) {
			case 'method':
				return $this->_router->getMethod();
				break;
			case 'controller':
				return preg_replace('/controller/i', '', $this->_router->getController());
				break;
			case 'params':
				return $this->_router->getParam( $params );
				break;
			case 'segments':
				return $this->_router->segments();
				break;
			case 'segment':
				return $this->_router->segment( $params );
				break;
			case 'query':
				return $this->_router->getQuerystring();
				break;
			case 'module':
				return rtrim($this->_router->getModule(), '\\');
				break;
			case 'url':
				return $this->_router->getFullUrl();
				break;
		}
	}
	
	/**
	 * 
	 * @param string $string
	 * @param integer $min_word_char
	 * @param array $exclude_words
	 */
	public function wordDensity($string, $min_word_char = 2, $exclude_words = array()) {
		
		$string = strip_tags($string);
	
		$initial_words_array  =  str_word_count($string, 1);
		$total_words = sizeof($initial_words_array);
	
		$new_string = $string;
	
		foreach($exclude_words as $filter_word) {
			
			$new_string = preg_replace('/\b'.$filter_word.'\b/i', '', $new_string);
		}
	
		$words_array = str_word_count($new_string, 1);
	
		$words_array = array_filter($words_array, create_function('$var', 'return (strlen($var) >= '.$min_word_char.');'));
	
		$popularity = array();
	
		$unique_words_array = array_unique($words_array);
	
		foreach($unique_words_array as $key => $word) {
			
			preg_match_all('/\b'.$word.'\b/i', $string, $out);
	
			$count = count($out[0]);
	
			$percent = number_format((($count * 100) / $total_words), 2);
	
			$popularity[$key]['word'] = $word;
			$popularity[$key]['count'] = $count;
			$popularity[$key]['percent'] = $percent.'%';
		}
	
		function cmp($a, $b) {
			return ($a['count'] > $b['count']) ? +1 : -1;
		}
	
		usort($popularity, 'cmp');
	
		return $popularity;
	}
}
