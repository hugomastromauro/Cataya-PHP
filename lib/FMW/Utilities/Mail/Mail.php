<?php

namespace FMW\Utilities\Mail;

use FMW\Utilities\Template\Template;

/** 
 * 
 * Classe Mail
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Mail 
 * @subpackage Utilities
 *  
 */ 
class Mail 
	extends \FMW\Object {	
	
	/**
	 * 
	 * @var string
	 */
	private $_to;

	/**
	 * 
	 * @var string
	 */
    private $_cc;

    /**
     * 
     * @var string
     */
    private $_bcc; 
    
    /**
     * 
     * @var string
     */
    private $_subject;

    /**
     * 
     * @var string
     */
    private $_from; 
    
    /**
     * 
     * @var string
     */
    private $_headers; 
    
    /**
     * 
     * @var bool
     */
    private $_file = false;
    
    /**
     * 
     * @var bool
     */
    private $_html = false;
    
    /**
     * 
     * @var string
     */
    private $_files = array();
    
    /**
     * 
     * @var string
     */
    private $_body;
    
    /**
     * 
     * @var string
     */
    private $_template;

    /**
     * 
     * @var string
     */
    private $_mime;
	
    /**
     * 
     * @param array $params
     * @throws Exception
     */
    public function __construct( array $params ) 
    {
    	
    	if ( ! ( isset( $params['to'] ) && $this->checkEmail( $params['to'] ) )  
    			|| ! ( isset( $params['from'] ) && $this->checkEmail($params['from']) )
    			|| ! isset( $params['subject'] ) ) 
    				throw new Exception ( "Dados obrigatórios não informados!" );
    			
    	$this->_to = $params['to'];
    	$this->_subject = $params['subject'];
    	$this->_from = $params['from'];
    	$this->_body = $params['body'];
    	
    	$this->_template = isset($params['template']) ? $params['template'] : null;
    	
    	$this->_cc = isset($params['cc']) ? $params['cc'] : null;
    	$this->_bcc = isset($params['bcc']) ? $params['bcc'] : null;
    	$this->_html = isset($params['html']) ? $params['html'] : $this->_html;
    	$this->_file = isset($params['file']) ? $params['file'] : $this->_file;
    	$this->_files = isset($params['files']) ? $params['files'] : array();
  		
    	$this->setHeaders();
    	
    	if ($this->_file)
    		$this->setFiles();
    }
    
   /**
    * 
    */
    public function setHeaders()  
    {  
    	$this->_headers = "From: {$this->_from}\r\n"; 
        
        if ( $this->_html || isset($this->_template) ) 
        { 
            $this->_headers .= "MIME-Version: 1.0\r\n"; 
            $this->_headers .= "Content-type: text/html; charset=utf-8\r\n"; 
        }
        
        if ( $this->_file )
        {
        	$semi_rand = md5(time()); 
			$this->_mime = "==Multipart_Boundary_x{$semi_rand}x"; 
			$this->_headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$this->_mime}\"\r\n"; 
        }
        
        $this->_headers .= isset($this->_cc) ? "Cc: {$this->_cc}\r\n" : '';
        $this->_headers .= isset($this->_bcc) ? "Cc: {$this->_bcc}\r\n" : '';
    } 
    
    /**
     * 
     */
    private function setBody() {
    	
    	if ( isset( $this->_template ) )
    	{
    		if ( is_file( $this->_template ) ) {
    			
    			$template = new Template( $this->getAll() );
    			$this->_body = $template->compile( $this->_template );
    		}
    	}
    	
    	if ( $this->_file ) {
    		$this->_body .= "This is a multi-part message in MIME format.\n\n" . "--{$this->_mime}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $this->_body . "\n\n"; 
			$this->_body .= "--{$this->_mime}\n";
    	}
    }
    
    /**
     * 
     * @throws Exception
     */
    private function setFiles() {
    	
    	for ($i= 0; $i < count($this->_files); $i++) {
    		
    		if ( $this->checkFile( $this->_files[$i] ) === false ) throw new Exception('Arquivo inválido!');
    		
			$file = fopen($this->_files[$i],"rb");
			$data = fread($file, filesize( $this->_files[$i] ) );
			fclose($file);
			
			$data = chunk_split(base64_encode($data));
			$this->_body .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$this->_files[$i]\"\n" . 
			"Content-Disposition: attachment;\n" . " filename=\"$this->_files[$i]\"\n" . 
			"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			$this->_body .= "--{$this->_mime}\n";
			
		}
    }
	
	/**
	 * 
	 * @param string $email
	 * @return boolean
	 */
	private function checkEmail( $email ) {
    	
    	if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) )
			return false;
					
		return true;
    }
    
    /**
     * 
     * @param string $file
     * @return boolean
     */
    private function checkFile( $file ) {
    	
    	if ( file_exists( $file ) )
    		return true;
    		
    	return false;
    }
	
    /**
     * 
     * @return boolean
     */
    public function send()  
    { 
    	
    	$this->setBody();
    	
        if ( mail( $this->_to, $this->_subject, $this->_body, $this->_headers ) )
        	return true;

        return false;
    }
}

