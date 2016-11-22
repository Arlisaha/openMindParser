<?php

namespace openMindParser\Objects;

use \DOMDocument;

class Document 
{
	private $path;
	private $name;
	private $size;
	private $domDocument;
	private $rootNode;
	
	/**
	 * Perform usual checks over the given path and if everything is fine, fill class attributes and build tree nodes objects.
	 * 
	 * @param String $path : Path's file to open.
	 */
	public function __construct($path) {
		if(!file_exists($path)) {
			throw new \InvalidArgumentException('The given path : "'.$path.'" is invalid.');
		}
		$this->path = $path;
		
		$this->name = basename($path);
		
		$this->size = filesize($path);
		
		$this->domDocument = new DOMDocument();
		$this->domDocument->load($path);
		
		$this->rootNode = new Node($this->domDocument->getElementsByTagName(Node::NODE_NODENAME)[0]);
	}
}