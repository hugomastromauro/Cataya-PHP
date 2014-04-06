<?php

namespace CATAYA\View\Helper;

/** 
 * 
 * Classe Util
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2010, catayaphp.com. 
 * @access public  
 * @package Helper 
 * @subpackage View
 *  
 */ 
class Util
	extends \FMW\View\Helper\AHelper {
	
	/**
	 * 
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;
	
	/**
	 * 
	 * @param \Doctrine\ORM\EntityManager $entityManager
	 */
	public function __construct( \Doctrine\ORM\EntityManager $entityManager ) {
		
		parent::__construct();
		
		$this->entityManager = $entityManager;
	}
}
