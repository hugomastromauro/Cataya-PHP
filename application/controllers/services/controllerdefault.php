<?php

namespace controllers\services;

/**
 *
 * Classe ControllerDefault
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package services
 * @subpackage controllers
 */
class ControllerDefault
	extends \CATAYA\Controller\ControllerServices {

	/**
	 * (non-PHPdoc)
	 * @see \CATAYA\Controller\ControllerServices::init()
	 */
	public function init() {
	
		parent::init();
	}

	/**
	 * (non-PHPdoc)
	 * @see \CATAYA\Controller\ControllerServices::getAction()
	 */
	public function getAction( array $params ) {}
}