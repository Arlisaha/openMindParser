<?php

namespace OpenMindParser\Models;

use \InvalidArgumentException;
use \ArrayIterator;

/*A class to store a collection of Node Objects as a Traversable entity.*/
class NodeList implements \IteratorAggregate
{
	/**
	 * @var Node[]
	 */
	private $list;
	
	public function __construct(array $list = null) {
		if(empty($list)) {
			$list = [];
		}
		
		foreach($list as $node) {
			if(!($node instanceof Node)) {
				throw new InvalidArgumentException('The array must contain only Node objects. "'.get_class($node).'" given.');
			}
		}
		
		$this->list = $list;
	}
	
	/**
	 * Method to retrieve the iterrator on the list property.
	 * 
	 * @return ArrayIterator : the ArrayInterrator instance with the current collection.
	 */
	public function getIterator() {
		return new ArrayIterator($this->list);
	}
	
	/**
	 * Add a Node object to the collection.
	 * 
	 * @param Node $node : The Node instance to add to the current collection.
	 */
	public function add(Node $node) {
		$this->list[] = $node;
	}
}