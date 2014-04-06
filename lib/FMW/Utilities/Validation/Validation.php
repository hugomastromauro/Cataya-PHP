<?php

namespace FMW\Utilities\Validation;

/** 
 * 
 * Classe Validation
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com. 
 * @access public  
 * @package Validation 
 * @subpackage Utilities
 *  
 */  
class Validation
	implements \FMW\Utilities\Validation\IValidation {
	
	/**
	 * 
	 * @var array
	 */
	private $_errors = array();
	
	/**
	 * 
	 * @var array
	 */
	private $_data = array();	
	
	/**
	 * 
	 * @var array
	 */
	private $_messages = array();
	
	/**
	 * 
	 * @var array
	 */ 
	private $_rules = array();
	
	/**
	 * 
	 * @var \FMW\Application\Request\Request
	 */
	private $_request;
	
	/**
	 * 
	 * @var boolean
	 */
	private	$_success = true;
	
	/**
	 * 
	 * @param array $rules
	 * @param array $messages
	 * @param \FMW\Application\Request\Request $request
	 */
  	public function __construct ( array $rules, array $messages, \FMW\Application\Request\Request $request = null ) {
  		
		$this->_rules = $rules;
		$this->_messages = $messages;
		$this->_request = $request;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function validate() {
						
		foreach( $this->_rules as $field => $value ) {
						
			if (isset($_FILES[$field])) 
			{								
				$value = $_FILES[$field];				
			} 
			else 
			{
				if (isset($this->_request)) {														
					$value = $this->_request->$field;						
				}else{
					$value = is_string( $_REQUEST[$field] ) ?  $this->sanitize( $_REQUEST[$field] ) : $_REQUEST[$field];
				}
			}
			
			$this->setData( $value, $field );
		}
		
		foreach( $this->_rules as $field => $value ) {
			
			if ( is_array($value['rules']) ) {

				foreach( $value['rules'] as $newValue ) {
					
					if ( is_object($newValue) ) {
						
						$this->validateObject( $field, $value, $newValue );
						
					} else {
						
						$this->validateFunction( $field, $newValue );
					}
				}
				
			} else {													
				
				if ( is_object( $value['rules'] ) ) {
					
					$this->validateObject( $field, $value, $value['rules'] );
					
				} else {
					
					$this->validateFunction( $field, $value );
				}
			}
		}

		return $this->_success;
	}
	
	/**
	 * 
	 * @param string $field
	 * @param array $value
	 * @param \FMW\Utilities\Validation\ARules $obj
	 * @throws \FMW\Utilities\Validation\Exception
	 */
	private function validateObject( $field, array $value, \FMW\Utilities\Validation\ARules $obj ) {
		
		$obj->setValidation($this);
		
		if (!(is_callable(array($obj, $obj->getMethod())))) 
			throw new \FMW\Utilities\Validation\Exception('Método não encontrado!');
		
		if (!call_user_func(array($obj, $obj->getMethod()), $this->getData($field), $field, $obj->getParams()))
		{			
			if (!isset($this->_messages['error'][$obj->getMethodError()])) 
				throw new \FMW\Utilities\Validation\Exception('Mensagem de erro não definida!');
			
			$this->_success = false;
			$this->setError($this->_messages['error'][$obj->getMethodError()], $field, $value['label'], $value);
		}
	}
	
	/**
	 * 
	 * @param string $field
	 * @param array $value
	 */
	private function validateFunction( $field, array $value ) {
		
		$label = $value['label'];
		$rules = $value['rules'];
							
		$value = $this->getData($field);
		$check = preg_split('/\|/', $rules);					

		foreach ($check as $function)
		{
			$callback = NULL;					
			
			if (preg_match("/:/i", $function))
			{									
				list($function, $callback) = explode(":", $function);				
			}							
			
			if (strpos($function, '[') !== FALSE AND preg_match_all('/\[(.*?)\]/', $function, $matches))
			{
				$x = explode('[', $function);
				$function = current($x);

				for ($x = 0; $x < count($matches['0']); $x++)
				{						
					if ($matches['1'][$x] != '')
					{
						if (isset($_POST[$matches['1'][$x]]))
						{
							$params[] = $this->getData($matches['1'][$x]);
						}
						else
						{
							$param = str_ireplace("'", '', $matches['1'][$x]);
							$param = str_ireplace('"', '', $matches['1'][$x]);
							$params[] = $param;
						}
					}
				}
			}				

			if (strpos($callback, '[') !== FALSE AND preg_match_all('/\[(.*?)\]/', $callback, $matches))
			{
				$x = explode('[', $callback);
				$callback = current($x);
				
				for ($x = 0; $x < count($matches['0']); $x++)
				{											
					if ($matches['1'][$x] != '')
					{
						if (isset($_POST[$matches['1'][$x]]))
						{
							$params[] = $this->getData($matches['1'][$x]);
						}
						else
						{
							$param = str_ireplace("'", '', $matches['1'][$x]);
							$param = str_ireplace('"', '', $matches['1'][$x]);	
							$params[] = $param;
						}
					}
				}
			}
			
			if (!isset($params)) $params = NULL;
				
			if (is_callable(array($this, $function)))
			{												
				if (call_user_func(array($this, $function), $value, $field, $params))
				{																
					$this->callback($this, $callback, $field, $label, $value);									
				}
				else
				{																
					$this->_success = false;
					$this->setError($this->_messages['error'][$function], $field, $label, $value);
				}
			}
			else
			{
				if ($function == 'required')
				{				
					if (!$this->getData($field) || $this->getData($field) == null)
					{															
						$this->_success = false;
						$this->setError($this->_messages['error']['required'], $field, $label, $value);
					}
					else
					{
						$this->callback($this, $callback, $field, $label, $value);							
					}
				}					
			}				
		}		
	}
	
	/**
	 * 
	 * @param object $obj
	 * @param string $callback
	 * @param string $field
	 * @param string $label
	 * @param mixed $value
	 */
	private function callback($obj, $callback, $field, $label, $value) {
				
		if (is_callable(array($obj, $callback)))
		{															
			if (call_user_func(array($obj, $callback), $value, $field) == false)
			{								
				$this->_success = false;
				$this->setError($this->_messages['error'][$callback], $field, $label, $value);
			}
		}
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function success() {
		return $this->_success;
	}
	
	/**
	 * 
	 * @param unknown $bool
	 */
	public function setSuccess($bool) {
		$this->_success = $bool;
	}
	
	/**
	 * 
	 * @param mixed $value
	 * @param string $field
	 */
	public function setData($value, $field) {
		$this->_data[$field] = $value;
	}
	
	/**
	 * 
	 * @param string $error
	 * @param string $params
	 */
	public function setLevelError($error, $params = null) {
		
		$msg = $this->_messages['error'][$error];
		
		if (is_array($params)) {
			$this->errors_[$error] = array('message' => $this->printf_array($msg, $params));
		} else {
			$this->errors_[$error] = array('message' => $msg);
		}		
	}
	
	/**
	 * 
	 * @param string $msg
	 * @param string $field
	 * @param string $label
	 * @param string $value
	 * @param string $params
	 */
	public function setError($msg, $field, $label, $value, $params = null) {
		
		if (is_array($params)) {
			$this->_errors[$field] = array('message' => $this->printf_array($msg, array($label, $value, $params)));
		} else {
			$this->_errors[$field] = array('message' => sprintf($msg, $label, $value, $params));
		}
	}
	
	/**
	 * 
	 * @param array $format
	 * @param array $arr
	 * @return mixed
	 */
	protected function printf_array($format, $arr) {
    	return call_user_func_array('printf', array_merge((array)$format, $arr));
	}
	
	/**
	 * 
	 * @param string $field
	 * @return multitype:
	 */
	public function getData($field) {
		return $this->_data[$field];
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getAllData() {
		return $this->_data;
	}
	
	/**
	 * 
	 * @param string $field
	 * @return array
	 */
	public function getError($field) {
		return $this->_errors[$field];
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getAllError() {
		return $this->_errors;
	}	
	
	/**
	 * 
	 * @param string $value
	 * @return string
	 */
	private function sanitize( $value )
	{		
		if ( !is_array( $value ) ) {
			//return filter_var( $value, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_MAGIC_QUOTES );
			return htmlentities($value, ENT_QUOTES, 'UTF-8');
		}
		
		foreach ($value as $k => $v ) {
			$value[$k] = $this->sanitize($v);
		}

		return $value;
	}
}
