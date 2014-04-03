<?php

namespace FMW\View\Helper;

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
class Currency
	extends \FMW\View\Helper\AHelper {
	
	/**
	 * 
	 * @param array $params
	 * @throws Exception
	 */
	public function __construct(array $params) {
		
		parent::__construct();
		
		if (!$params['locale']) throw new Exception('Localização não definida!');
		setlocale(LC_MONETARY, $params['locale']);
	}
	
	/**
	 * 
	 * @param string $number
	 */
	public function money( $number ) {
		return money_format( '%!i', \FMW\Utilities\Number\Number::convertToNumber( $number ) );
	}
}

