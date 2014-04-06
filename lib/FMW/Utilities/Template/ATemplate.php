<?php

namespace FMW\Utilities\Template;

/**
 *
 * Classe Abstrata ATemplate
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Template
 * @subpackage Utilities
 *
 */
abstract class ATemplate 
	extends \FMW\Object {
	
	/**
	 * 
	 * @var string
	 */
	private $token = '%%';
	
	/**
	 * 
	 * @var array
	 */
	private $stack = array();
	
	/**
	 * 
	 * @param array $params
	 */
	public function __construct( array $params = null ) {
		
		parent::__construct();
		
		if (is_array($params))
			$this->_data = $params;
	}
	
	/**
	 * 
	 * @param string $token
	 */
	protected function setToken( $token ) {
		$this->token = $token;
	}
	
	/**
	 * 
	 * @param string $template
	 * @return string
	 */
	private function run( $template ) {
		
		ob_start ();
		eval ('?>' . $template );
		return ob_get_clean();
	}
	
	/**
	 * 
	 * @param string $element
	 */
	protected function wrap( $element ) {
		
		$this->stack[] = $this->_data;
		
		foreach ($element as $k => $v) {
			$this->_data[$k] = $v;
		}
	}
	
	/**
	 * 
	 */
	protected function unwrap() {
		$this->_data = array_pop($this->stack);
		$this->stack = null;
	}
	
	/**
	 * 
	 * @param string $name
	 */
	private function parse( $name ) {
		
		if (isset($this->_data[$name])) {
			echo $this->_data[$name];
		} else {
			echo $this->token[0] . $name . $this->token[1];
		}
	}
	
	/**
	 * 
	 * @param string $template
	 * @return mixed
	 */
	protected function parseBehindTemplate( $template ) {
		
		$template = preg_replace('~\\' . $this->token[0] . '(\w+)\\' . $this->token[1] . '~', '<?php $this->parse(\'$1\'); ?>', $template);
		$template = preg_replace('~\\' . $this->token[0] . 'LOOP:(\w+)\\' . $this->token[1] . '~', '<?php foreach ($this->_data[\'$1\'] as $ELEMENT): $this->wrap($ELEMENT); ?>', $template);
		$template = preg_replace('~\\' . $this->token[0] . 'ENDLOOP:(\w+)\\' . $this->token[1] . '~', '<?php $this->unwrap(); endforeach; ?>', $template);
		
		return $template;
	}
	
	/**
	 * 
	 * @param string $template
	 * @param string $path
	 * @return Ambigous <string, mixed>|Ambigous <>|Ambigous <mixed, string>|mixed
	 */
	protected function parseAfterTemplate( $template, $path = null ) {
		
		$_ = $this;
		$_data = $this->_data;
				
		$template = preg_replace_callback('/\\' . $this->token[0] . 'LOOP:(\w+)\\' . $this->token[1] . '(.*?)' . '\\' . $this->token[0] . 'ENDLOOP:(\w+)\\' . $this->token[1] . '/s', function ($match) use($_, $_data) {
				
			$html = '';
			
			if ($_data[$match[1]]) {
				foreach($_data[$match[1]] as $ELEMENT) {
					
					$_->wrap($ELEMENT);
					$html .= $_->parseAfterTemplate( $match[2] );
					$_->unwrap();
			
				}
			}
			return $html;
		
		}, $template);
		
		$template = preg_replace_callback('~\\' . $this->token[0] . '(\w+)\\' . $this->token[1] . '~', function ($match) use($_data) {

			return $_data[$match[1]];
			
		}, $template);
		
		$template = preg_replace_callback('~\\' . $this->token[0] . 'PARTIAL:(\w+)\\' . $this->token[1] . '~', function ($match) use($_, $path) {
			
			$file = $path . 'content' . DIRECTORY_SEPARATOR . $match[1] . '.php';
			
			if ( is_file( $file ) )
				return $_->parseAfterTemplate( file_get_contents( $file ) );
					
		}, $template);
		
		$template = preg_replace_callback('~\\' . $this->token[0] . 'PARTIAL:(\w+):(\w+)\\' . $this->token[1] . '~', function ($match) use($_, $path) {
			
			$path = trim(preg_replace('/\s*public\/(.*)/', '', $path));
			
			$file = $path . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $match[1] . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . $match[2] . '.php';
			
			if ( is_file( $file ) )
				return $_->parseAfterTemplate( file_get_contents( $file ) );
				
		}, $template);
		
		$template = preg_replace_callback('~\\' . $this->token[0] . 'HELPER:(\w+)\[(.*)\]\\' . $this->token[1] . '~', function ($match) use($_) {
			
			$params = preg_replace('/\'/', '', $match[2]);
			$params = preg_replace('/\"/', '', $params);
			
			return $_->getHelper( 'helper' )->$match[1]($params); 
			
		}, $template);
	
		return $template;
	}
	
	/**
	 * 
	 * @param string $file
	 * @param string $path
	 * @param array $params
	 * @throws Exception
	 * @return string|Ambigous <\FMW\Utilities\Template\Ambigous, mixed, string>
	 */
	public function compile( $file, $path = null, array $params = null ) {

		try {
			$file = fopen ( $file, 'r' );
		} catch (Exception $e) {
			throw new Exception ( "Não foi possível abrir o arquivo template: {$file}" );
		}
	
		if ($file) {
			
			$template = '';
			while ( ! feof ( $file ) ) {
				$template .= fread ( $file, 65536 );
				flush ();
			}
			fclose ( $file );
		}
		
		if ($params['compile'] === false) 
			return $this->run( $template );
		
		return $this->parseAfterTemplate( $this->run( $this->parseBehindTemplate( $template ) ), $path );
	}
	
	/**
	 * 
	 * @param string $string
	 * @param string $path
	 * @param array $params
	 * @return string|Ambigous <\FMW\Utilities\Template\Ambigous, mixed, string, unknown>
	 */
	public function compileText( $string, $path = null, array $params = null ) {
		
		if ($params['compile'] === false)
			return $this->run( $string );
		
		return $this->parseAfterTemplate( $this->run( $this->parseBehindTemplate( $string ) ), $path );
	}
}