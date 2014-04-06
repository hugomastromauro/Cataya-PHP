<?php

namespace CATAYA\ORM;

/**
 *
 * Interface de Classe IEntityRepository
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package ORM
 * @subpackage CATAYA
 *
 */
interface IEntityRepository
{
	/**
	 * 
	 * @param int $page
	 * @param int $max
	 */
	public function selectAll( $page = 1, $max = 12 );
	
	/**
	 * 
	 * @param \FMW\Application\Request\Request $request
	 */
	public function insert( \FMW\Application\Request\Request $request );
	
	/**
	 * 
	 * @param \FMW\Application\Request\Request $request
	 */
	public function update( \FMW\Application\Request\Request $request );
	
	/**
	 * 
	 * @param \FMW\Application\Request\Request $request
	 */
	public function delete( \FMW\Application\Request\Request $request );
}