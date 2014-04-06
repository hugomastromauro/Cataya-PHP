<?php

namespace FMW\Utilities\XML;

use SimpleXMLElement;

/**
 * 
 * Classe XML
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright GPL © 2014, catayaphp.com.
 * @access public
 * @package XML
 * @subpackage Utilities
 *            
 */
class XML extends \FMW\Object {
	
	/**
	 *
	 * @var string
	 */
	private $root;
	
	/**
	 *
	 * @var SimpleXMLElement
	 */
	private $xml;
	
	/**
	 *
	 * @var string
	 */
	private $charset;
	
	/**
	 *
	 * @var mixed
	 */
	private $extra;
	
	/**
	 *
	 * @param array $params        	
	 * @throws Exception
	 */
	public function __construct(array $params) {
		if (! isset ( $params ['root'] ))
			throw new Exception ( 'Root não definido!' );
		
		$this->charset = isset ( $params ['charset'] ) ? $params ['charset'] : 'UTF-8';
		$this->extra = isset ( $params ['extra'] ) ? $params ['extra'] : '';
		
		$this->xml = simplexml_load_string ( "<?xml version=\"1.0\" encoding=\"{$this->charset}\" " . $this->extra . "?><{$params['root']} />" );
		$this->root = $params ['root'];
	}
	
	/**
	 *
	 * @param array $item        	
	 */
	public function addArray(array $data, $rootNodeName = null, $xml = null) {
		$xml = $xml == null ? $this->xml : $xml;
		$rootNodeName = $rootNodeName == null ? $this->root : $rootNodeName;
		
		foreach ( $data as $key => $value ) {
			if (is_numeric ( $key )) {
				$key = "unknownNode_" . ( string ) $key;
			}
			
			$key = preg_replace ( '/[^a-z]/i', '', $key );
			
			if (is_array ( $value )) {
				$node = $xml->addChild ( $key );
				$this->addArray ( $value, $rootNodeName, $node );
			} else {
				$value = htmlentities ( $value );
				$xml->addChild ( $key, $value );
			}
		}
	}
	
	/**
	 * 
	 * @return SimpleXMLElement
	 */
	public function getXML() {
		return $this->xml;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getCharset() {
		return $this->charset;
	}
	
	/**
	 * 
	 * @return mixed
	 */
	public function getDocumentXML() {
		return $this->xml->asXML ();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FMW\Object::toArray()
	 */
	public function toArray($node) {
		$occurance = array ();
		if ($node->hasChildNodes ()) {
			foreach ( $node->childNodes as $child ) {
				if (! isset ( $occurance [$child->nodeName] )) {
					$occurance [$child->nodeName] = null;
				}
				$occurance [$child->nodeName] ++;
			}
		}
		if (isset ( $child )) {
			if ($child->nodeName == '#text') {
				$result = html_entity_decode ( htmlentities ( $node->nodeValue, ENT_COMPAT, 'UTF-8' ), ENT_COMPAT, 'ISO-8859-15' );
			} else {
				if ($node->hasChildNodes ()) {
					$children = $node->childNodes;
					for($i = 0; $i < $children->length; $i ++) {
						$child = $children->item ( $i );
						if ($child->nodeName != '#text') {
							if ($occurance [$child->nodeName] > 1) {
								$result [$child->nodeName] [] = $this->toArray ( $child );
							} else {
								$result [$child->nodeName] = $this->toArray ( $child );
							}
						} else if ($child->nodeName == '0') {
							$text = $this->toArray ( $child );
							if (trim ( $text ) != '') {
								$result [$child->nodeName] = $this->toArray ( $child );
							}
						}
					}
				}
				if ($node->hasAttributes ()) {
					$attributes = $node->attributes;
					if (! is_null ( $attributes )) {
						foreach ( $attributes as $key => $attr ) {
							$result ["@" . $attr->name] = $attr->value;
						}
					}
				}
			}
			return $result;
		} else {
			return null;
		}
	}
}
