<?php

namespace FMW\Utilities\Image;

/**
 *
 * Class Image
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1
 * @copyright  GPL © 2010, hugomastromauro.com.
 * @access public
 * @package FMW
 * @subpackage lib
 *
 */
class Upload 
	extends \FMW\Utilities\Upload\AUpload {
	
	/**
	 * 
	 * @var int
	 */
	private $imageQualityNormal = 3;
	
	/**
	 * 
	 * @var int
	 */
	private $imageQualityThumb = 1;
	
	/**
	 * 
	 * @var int
	 */
	private $maxMemoryUsage = 128;
	
	/**
	 * 
	 * @var int
	 */
	private $minWidthSize = 300;
	
	/**
	 *
	 * @var int
	 */
	private $minHeightSize = 300;
	
	/**
	 * 
	 * @var string
	 */
	private $newName = null;
	
	/**
	 * 
	 * @var int
	 */
	private $width = 0;
	
	/**
	 * 
	 * @var int
	 */
	private $height = 0;
	
	/**
	 * 
	 * @var array
	 */
	private $sizes = array();
	
	/**
	 * 
	 * @var array
	 */
	private $borders = array();
	
	/**
	 * 
	 * @var bool
	 */
	private $proportion = false;
	
	/**
	 *
	 * @var bool
	 */
	private $crop = false;
	
	/**
	 * 
	 * @var array
	 */
	private $files = array();


	/**
	 * 
	 * @param array $params
	 */
	public function __construct($fileToUpload, array $params = array()) {
		
		if (isset($params['settings']['sizes']))
			$this->sizes = $params['settings']['sizes'];
		
		if (isset($params['settings']['borders']))
			$this->borders = $params['settings']['borders'];
			
		if (isset($params['settings']['imageQualityNormal']))
			$this->imageQualityNormal = $params['settings']['imageQualityNormal'];
			
		if (isset($params['settings']['imageQualityThumb']))
			$this->imageQualityThumb = $params['settings']['imageQualityThumb'];
			
		if (isset($params['settings']['proportion']))
			$this->proportion = $params['settings']['proportion'];
		
		if (isset($params['settings']['crop']))
			$this->crop = $params['settings']['crop'];
		
		if (isset($params['settings']['minWidthSize']))
			$this->minWidthSize = $params['settings']['minWidthSize'];
		
		if (isset($params['settings']['minHeightSize']))
			$this->minHeightSize = $params['settings']['minHeightSize'];
		
		if (isset($params['settings']['newName']))
			$this->newName = $params['settings']['newName'];
		
		if (isset($params['settings']['width']) && isset($params['settings']['height'])) {
			$this->width = $params['settings']['width'];
			$this->height = $params['settings']['height'];
		}
		
		parent::__construct($fileToUpload, $params);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FMW\Utilities\Upload.AUpload::handleUpload()
	 */
	public function handleUpload() {
		
		$this->prepare();
				
		list($width, $height, $type, $attr) = getimagesize($this->getUploadTemp());
				
		if ($width < $this->minWidthSize || $height < $this->minHeightSize) return array('error'=> "Tamanho da imagem não suportado. Deve ser maior ou igual a {$this->minWidthSize}px x {$this->minHeightSize}px.");
		
		$filename = $this->newName ? $this->newName : $this->filename;
		
		$oldfile = $this->path . $filename . $this->extension;
		
		if ($this->upload->save($this->path . $this->filename . $this->extension)) {
			
			if ( count($this->sizes) > 0 && $this->width == 0 && $this->height == 0 ) {

				$image = new Image();
				
				$count = 0;
				foreach ($this->sizes as $name => $size)
				{
					$newfile = $this->path . "{$filename}_{$name}" . $this->extension;
			
					if (isset($this->borders))
						$border = $this->borders[$count];
			
					$h = $this->proportion ? $image->proportion($oldfile, $size) : $size;
			
					$image->resize($oldfile, $newfile, $size, $h, $this->imageQualityNormal, $border, $this->crop);
			
					$this->files['resize'][$name] = "{$filename}_{$name}" . $this->extension;
			
					$count++;
				}
				
				//@unlink($this->path . $filename . $this->extension);

			} else if ( $this->width > 0 && $this->height > 0 && count($this->sizes) == 0 ) {
				
				$image = new Image();
				
				$newfile = $this->path . $filename . $this->extension;
				
				if (isset($this->borders))
					$border = $this->borders[$count];
					
				$image->resize($oldfile, $newfile, $this->width, $this->height, $this->imageQualityNormal, $border, $this->crop);
					
				$this->files[] = $filename;
				
				unlink($this->path . $this->filename . $this->extension);
				
			} else {
			
				$this->files[] = $filename;
			}
			
			return array('success'=>true);
			
		} else {
			
			return array('error'=> 'Não foi possível salvar o arquivo.' .
                'O upload foi cancelado ou o servidor está ocupado!');
		}
	}
}

