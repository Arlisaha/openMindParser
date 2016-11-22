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
	public function __construct(DOMDocument $domDocument = null, Node $rootNode = null, $path = null, $name = null, $size = null) {
		$this->path = $path;
		$this->name = $name;
		$this->size = $size;
		$this->domDocument = $domDocument;
		$this->rootNode = $rootNode;
	}
	
	public function getPath() {
		return $this->path;
	}
	
	public function setPath($path) {
		$this->path = $path;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getSize() {
		return $this->size;
	}
	
	public function setSize($size) {
		$this->size = $size;
	}
	
	public function getDomDocument() {
		return $this->domDocument;
	}
	
	public function setDomDocument($domDocument) {
		$this->domDocument = $domDocument;
	}
	
	public function getRootNode() {
		return $this->rootNode;
	}
	
	public function setRootNode($rootNode) {
		$this->rootNode = $rootNode;
	}
}