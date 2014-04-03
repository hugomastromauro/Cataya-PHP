<?php

namespace FMW\Utilities\Pagination;

use DoctrineExtensions\Versionable\Exception;

/** 
 * 
 * Class Session
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2010, hugomastromauro.com. 
 * @access public  
 * @package FMW 
 * @subpackage lib
 *  
 */  
class Pagination
	extends \FMW\Object {
	
	/**
	 * 
	 * @var string
	 */
	private static $pages;
	
	/**
	 * 
	 * @var string
	 */
	private static $query;
	
	/**
	 * 
	 * @param array $params
	 * @throws Exception
	 */
	static public function create( array $params ) {
		
		if (!isset($params['url'])
					|| !isset($params['total'])
					|| !isset($params['max'])
					|| !isset($params['page']))
							throw new Exception('Parâmetros não definidos!'); 
		
		$params['type'] = isset($params['type']) ? $params['type'] : 'ul';
		$params['selector'] = isset($params['selector']) ? $params['selector'] : 'page';
		$params['classactive'] = isset($params['classactive']) ? $params['classactive'] : 'active';
		$params['classstyle'] = isset($params['classstyle']) ? $params['classstyle'] : '';
		
		self::$pages = ceil($params['total'] / $params['max']); 
		self::$query = parse_url($params['url']);
		
		return self::renderHtml($params);
	}
	
	/**
	 * 
	 * @param array $params
	 */
	static public function renderHtml( array $params ) {
		
		parse_str(self::$query['query'], $query);
		
		$html = '<div class="cataya-pagination">';
		$rg = $query[$params['selector']] ? true : false;
		
		$page = $params['page'];
		
		$html .= "<span>Mostrando " . $page . " de " . self::getPages() . " páginas (" . $params['total'] . " resultados)</span>";
		
		if ($params['type'] == 'ul') {
			$html .= '<ul class="' . $params['classstyle'] . '">';
		}else if ($params['type'] == 'div') {
			$html .= '<div class="' . $params['classstyle'] . '">';
		}
		
		$start_range = $params['page'] - floor(7/2);
		$end_range = $params['page'] + floor(7/2);
		
		if($start_range <= 0)
		{
			$end_range += abs($start_range)+1;
			$start_range = 1;
		}
		if($end_range > self::$pages)
		{
			$start_range -= $end_range-self::$pages;
			$end_range = self::$pages;
		}
		$range = range($start_range, $end_range);
		
		for ($i = 1; $i <= self::$pages; $i++) {
			
			$url = '';
			
			if ($rg) {
				$url = preg_replace("/{$params['selector']}=.*/", "{$params['selector']}=$i", $params['url']);
			}else{
				if (count($query) >= 1) {
					$url = $params['url'] . "&{$params['selector']}={$i}";
				}else{
					$url = $params['url'].  "?{$params['selector']}={$i}";
				}
			}
			
			$active = $i == $params['page'] ? 'class="' . $params['classactive'] .  '"' : false;
			
			if($range[0] > 2 && $i == $range[0]) $html .= '<li> ... </li>';
			
			if($i==1 || $i == self::$pages || in_array( $i, $range ))
			{
			
				if ($params['type'] == 'ul') {
					$html .= "<li {$active}><a href=\"{$url}\">" . $i . '</a></li>';
				}else if ($params['type'] == 'div') {
					$html .= "<div {$active}><a href=\"{$url}\">" . $i . '</a></div>';
				}
			
			}			
		}
		
		if ($params['type'] == 'ul') {
			$html .= '</ul>';
		}else if ($params['type'] == 'div') {
			$html .= '</div>';
		}
		
		$html .= '</div>';
		
		return $html;
	}
	
	/**
	 * 
	 */
	static function getPages() {
		return self::$pages;
	}
}