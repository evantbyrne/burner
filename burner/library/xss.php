<?php

namespace Library;

/**
 * XSS Cleaning Library
 * @author Evan Byrne
 */
class Xss {
	
	/**
	 * @param XML to clean
	 * @param Array of allowed characters (optional)
	 * @param If true, then return XML tree instead of XML string
	 */
	public static function clean($xml, $allowed = false, $debug = false) {
		
		if(!$tree = Xml::parse("<wrapper>$xml</wrapper>")) {
			
			return false;
			
		}
		
		if(!$allowed) {
			
			$allowed = array(
				'a'=>array('attributes'=>array('href'=>'URL','title'=>'/^([ \-_a-zA-Z0-9\.\/\!]+)$/')),
				'img'=>array('attributes'=>array('src'=>'URL','title'=>'ANY','alt'=>'ANY')),
				'b'=>array('transform'=>'strong'),
				'i'=>array('transform'=>'em'),
				'strong'=>array(),
				'em'=>array(),
				'p'=>array()
			);
			
		}
		
		if(is_array($tree)) {
			
			$tree = self::clean_childnodes($tree,$allowed);
			return ($debug === false) ? Xml::build($tree) : $tree;
		
		} else {
			
			return false;
			
		}
	}
	
	/**
	 * @param Element to clean child nodes of
	 * @param Array of allowed characters
	 */
	public static function clean_childnodes($el, $allowed) {
		
		$tree = array();
		
		// Loop child nodes
		foreach($el as $i) {
			
			// Clean node
			$n = self::clean_node($i,$allowed);
			
			// Only add nodes that are not empty
			if(!empty($n)) {
				
				$tree[] = $n;
				
			}
		
		}
		
		return $tree;
		
	}
	
	/**
	 * @param Node to clean
	 * @param Array of allowed characters
	 */
	public static function clean_node($node, $allowed) {
		
		// Text Nodes
		if($node['type'] == 'text') {
			
			$tree[] = $node;
			
		}
		
		// Regular Nodes
		elseif(isset($allowed[$node['name']])) {
			
			// If transformation node EX: <b> to <strong>
			if(isset($allowed[$node['name']]['transform'])) {
				
				$node['name'] = $allowed[$node['name']]['transform'];
				$node = self::clean_node($node, $allowed);
				
			}
			
			// If node can contain attributes
			if(isset($allowed[$node['name']]['attributes'])) {
				
				// Clean attribute list
				$a = self::clean_node_attr($node['attributes'],$allowed[$node['name']]['attributes']);
				
				if(!empty($a)) {
					
					$node['attributes'] = $a;
					
				} else {
					
					unset($node['attributes']);
					
				}
			
			}
			
			// Otherwise, node cannot contain any attributes
			elseif(isset($node['attributes'])) {
				
				unset($node['attributes']);
				
			}
			
		}
		
		// Disallowed Node
		else {
			
			$node = array();
	
		}
		
		return $node;
	}
	
	/**
	 * @param Attributes
	 * @param Array of allowed characters
	 */
	public static function clean_node_attr($attributes, $allowed) {
		
		$list = array();
	
		// Loop attribute list
		foreach($attributes as $attr=>$value) {
			
			// If valid attribute
			if(isset($allowed[$attr])) {
				
				// If attribute can have any value add it to the list
				if($allowed[$attr] == 'ANY') {
					
					$list[$attr] = $value;
				
				}
				
				// URL accepting only attributes. Will accept invalid URLs, but they will be safe
				// /^[a-zA-Z]+[:\/\/]{1}[ -_a-zA-Z0-9-\.]{2,}\.[ -_a-zA-Z0-9-\.]{2,}[ -=\~_a-zA-Z%&\?\/\.]?$/
				elseif($allowed[$attr] == 'URL' AND !preg_match('/[;\(\)\[\]\'"\\\]+/',$value)){
					
					$list[$attr] = $value;
				
				}
				
				// Otherwise, treat the $allowed array key value as a regular expression
				elseif(preg_match("{$allowed[$attr]}",$value)) {
					
					$list[$attr] = $value;
				
				}
			
			}
		
		}
		
		return $list;
	
	}

}