<?php

namespace CATAYA\View\Helper;

/** 
 * 
 * Class Util
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
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
