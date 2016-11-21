<?php

namespace openMindParser\Objects;

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
	
	public function getIterator() {
		return new ArrayIterator($this->list);
	}
	
	public function add(Node $node) {
		$this->list[] = $node;
	}
}