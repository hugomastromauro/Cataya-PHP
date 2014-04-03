<?php

namespace FMW\Utilities\Upload;

use FMW\Utilities\File\File;

/**
 *
 * Abstract Image
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, hugomastromauro.com.
 * @access public
 * @package FMW
 * @subpackage lib
 *
 */
abstract class AUpload {
	
	/**
	 * 
	 * @var array
	 */
	protected $allowedExtensions = array();
	
	/**
	 * 
	 * @var integer
	 */
	protected $sizeLimit = 10485760;
	
	/**
	 *
	 * @var array
	 */
	protected $settings = array();
	
	/**
	 * 
	 * @var string
	 */
	protected $upload;
	
	/**
	 *
	 * @var string
	 */
	protected $file;
	
	/**
	 * 
	 * @var string
	 */
	protected $folder;
	
	/**
	 * 
	 * @var string
	 */
	protected $path;
	
	/**
	 * 
	 * @var string
	 */
	protected $filename;
	
	/**
	 * 
	 * @var string
	 */
	protected $extension;
	
	/**
	 * 
	 * @param array $allowedExtensions
	 * @param integer $sizeLimit
	 */
	public function __construct($fileToUpload, array $params = array()){
		
		$this->settings = $params['settings'];
		
		if (isset($params['settings']['allowedExtensions'])) {
			$allowedExtensions = array_map('strtolower', $params['settings']['allowedExtensions']);
			$this->allowedExtensions = $allowedExtensions;
		}
		
		if (isset($params['settings']['sizeLimit']))
			$this->sizeLimit = $params['settings']['sizeLimit'];
		
		$this->file = new File();
		
		if (isset($params['folder'])) {
			
			$this->folder = $params['folder'];
			$this->path = $params['basedir'] . $this->folder . '/';

			$this->file->createDirectory($this->path);
			
		} else {
			
			$this->basedir 	= $params['basedir'];
			$this->path = $params['basedir'];
		}

		$this->checkServerSettings();
		
		if (isset($_REQUEST[$fileToUpload])) {
			$this->upload = new UploadedFileXhr($_REQUEST[$fileToUpload], $this->settings);
		} else if (isset($_FILES[$fileToUpload])) {
			$this->upload = new UploadedFileForm($_FILES[$fileToUpload], $this->settings);
		} else {
			throw new Exception("No file selected.");
		}
	}
	
	/**
	 * 
	 */
	public function getFileName(){
		if (isset($this->filename))
			return $this->filename;
	}
	
	/**
	 * 
	 */
	public function getFileExtension() {
		if (isset($this->filename))
			return $this->extension;
	}
	
	/**
	 * 
	 */
	public function getUploadName(){
		if ($this->upload)
			return $this->upload->getName();
	}
	
	/**
	 * 
	 */
	public function getUploadTemp(){
		if ($this->upload)
			return $this->upload->getTemp();
	}
	
	/**
	 * 
	 */
	private function checkServerSettings(){
		
		$postSize = $this->toBytes(ini_get('post_max_size'));
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));
		
		if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
			$size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
			throw new Exception("increase post_max_size and upload_max_filesize to $size");
		}
	}
	
	/**
	 * 
	 * @param string $str
	 */
	private function toBytes($str){
		
		$val = trim($str);
		$last = strtolower($str[strlen($str)-1]);
		
		switch($last) {
			case 'g': $val *= 1024;
			case 'm': $val *= 1024;
			case 'k': $val *= 1024;
		}
		
		return $val;
	}
	
	/**
	 * 
	 * @throws Exception
	 */
	protected function prepare() {
		
		if (!is_writable($this->path))
			return array('error' => 'Erro do servidor. Diretório para upload deve ter permissão de escrita.');
		
		if (!$this->upload)
			return array('error' => 'No files were uploaded.');
		
		$size = $this->upload->getSize();
		
		if ($size == 0)
			return array('error' => 'File is empty.');
		
		if ($size > $this->sizeLimit)
			return array('error' => 'File is too large.');
		
		$pathinfo = pathinfo($this->getUploadName());
				
		if (isset($this->settings['newName'])) {
			$filename = $this->settings['newName'];
		}else{
			$filename = $pathinfo['filename'];
		}
		
		$ext = @$pathinfo['extension'];
		
		if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
			$these = implode(', ', $this->allowedExtensions);
			return array('error' => 'Extensão do arquivo inválida, tente uma destas opções: '. $these . '.');
		}
		
		$ext = ($ext == '') ? $ext : '.' . $ext;
		
		if(!$this->settings['replaceOldFile']){
			while (file_exists($this->path . $filename . $ext)) {
				$filename .= rand(10, 99);
			}
		}
		
		$this->extension = $ext;
		$this->filename = $filename;
	}

	/**
	 * 
	 * @return multitype:string |boolean
	 */
	public function handleUpload() {
		
		$this->prepare();
		
		if ($this->upload->save($this->path . $this->filename . $this->extension)) {
			return array('success'=>true);
		}else{
			return array('error'=> 'Não foi possível salvar o arquivo.' .
                'O upload foi cancelado ou o servidor está ocupado!');
		}
	}
}