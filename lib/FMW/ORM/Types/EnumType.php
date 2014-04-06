<?php

namespace FMW\ORM\Types;

use Doctrine\DBAL\Types\Type,
	Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 *
 * Classe EnumType
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Types
 * @subpackage ORM
 *
 */
abstract class EnumType extends Type
{
	/**
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * 
	 * @var array
	 */
	protected $values = array();
	
	/**
	 * 
	 * @param array $fieldDeclaration
	 * @param AbstractPlatform $platform
	 * @return string
	 */
	public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
	{
		$values = array_map(function($val) {
			return "'".$val."'";
		}, $this->values);

		return "ENUM(".implode(", ", $values).") COMMENT '(DC2Type:".$this->name.")'";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Doctrine\DBAL\Types.Type::convertToPHPValue()
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return $value;
	}

	/**
	 * (non-PHPdoc)
	 * @see Doctrine\DBAL\Types.Type::convertToDatabaseValue()
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if (!in_array($value, $this->values)) {
			throw new \InvalidArgumentException("Invalid '".$this->name."' value.");
		}
		return $value;
	}

	/**
	 * (non-PHPdoc)
	 * @see Doctrine\DBAL\Types.Type::getName()
	 */
	public function getName()
	{
		return $this->name;
	}
}