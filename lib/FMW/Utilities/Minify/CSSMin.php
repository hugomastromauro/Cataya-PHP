<?php

namespace FMW\Utilities\Minify;

/**
 *
 * Classe CSSMin
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Minify
 * @subpackage Uitlities
 *
 */
class CSSMin {
	
	/**
	 * 
	 * @var string
	 */
	protected $input = '';
	
	/**
	 * 
	 * @var integer
	 */
	protected $inputLength = 0;
	
	/**
	 * 
	 * @var \FMW\Config
	 */
	protected $config;
		
	/**
	 * Minify CSS
	 *
	 * @uses __construct()
	 * @uses min()
	 * @param array $css
	 * @return string
	 */
	public static function minify( $cssfiles, \FMW\Config $config ) {
		
		$cssmin = new CSSMin ( $cssfiles, $config );
		return $cssmin->min ();
		
	}
	
	/**
	 * 
	 * @param string $cssfiles
	 * @param \FMW\Config $config
	 */
	public function __construct( $cssfiles, $config ) {
		
		$input = '';
		
		$this->config = $config;
		
		foreach ($cssfiles as $file) {
			$input .= $this->checkAndFixDirs( file_get_contents( $file ), $file );
		}
		
		$this->input = str_replace ( '\r\n', '\n', $input );
		$this->inputLength = strlen ( $this->input );		
	}
	
	/**
	 * 
	 * @param resource $stream
	 * @param string $dir
	 * @return mixed|string
	 */
	protected function checkAndFixDirs( $stream, $dir ) {
		
		$dir = '/public/' . str_replace($this->config->controller->module->path, '', realpath(dirname($dir) . '/.'));	
		
		$that = $this;
		
		return preg_replace_callback( '/url\(\s*[\'"]?\/?(.+?)[\'"]?\s*\)/i' , function($s) use ($that, $dir) {
			
			$file = basename($s[1]);
			
			$dir = $that->normalizePath($dir . '/' . dirname($s[1]));
			
			return "url({$dir}/{$file})";
			
		}, $stream);
	}
	
	/**
	 * 
	 * @param string $path
	 * @return string
	 */
	public function normalizePath( $path ) {

		$parts = array();
		$path = str_replace('\\', '/', $path);
		$path = preg_replace('/\/+/', '/', $path);
		$segments = explode('/', $path);
		$test = '';
		
		foreach($segments as $segment) {
			
			if ($segment != '.') {
				
				$test = array_pop($parts);
				
				if(is_null($test))
					$parts[] = $segment;
				
				else if($segment == '..') {
					
					if($test == '..')
						$parts[] = $test;
	
					if($test == '..' || $test == '')
						$parts[] = $segment;
					
				} else {
					$parts[] = $test;
					$parts[] = $segment;
				}
			}
		}
		
		return implode('/', $parts);
	}
	
	/**
	 * 
	 * @return mixed
	 */
	protected function min() {
		
		$re1 = <<<'EOS'
		(?sx)
  		# quotes
 		(
    		"(?:[^"\\]++|\\.)*+"
  			| '(?:[^'\\]++|\\.)*+'
  		)
		|
  		# comments
  		/\* (?> .*? \*/ )
EOS;
	
		$re2 = <<<'EOS'
		(?six)
  		# quotes
  		(
    		"(?:[^"\\]++|\\.)*+"
  			| '(?:[^'\\]++|\\.)*+'
  		)
		|
  		# ; before } (and the spaces after it while we're here)
 		\s*+ ; \s*+ ( } ) \s*+
		|
  		# all spaces around meta chars/operators
  		\s*+ ( [*$~^|]?+= | [{};,>~+-] | !important\b ) \s*+
		|
  		# spaces right of ( [ :
  		( [[(:] ) \s++
		|
  		# spaces left of ) ]
  		\s++ ( [])] )
		|
  		# spaces left (and right) of :
  		\s++ ( : ) \s*+
  		# but not in selectors: not followed by a {
  		(?!
    	(?>
      	[^{}"']++
    		| "(?:[^"\\]++|\\.)*+"
    		| '(?:[^'\\]++|\\.)*+'
    	)*+
    	{
  		)
		|
  		# spaces at beginning/end of string
  		^ \s++ | \s++ \z
		|
  		# double spaces to single
  		(\s)\s+
EOS;
		
		$string = preg_replace("%$re1%", '$1', $this->input);
		$string = preg_replace("%$re2%", '$1$2$3$4$5$6$7', $string);
		
		return $string;
	}
}