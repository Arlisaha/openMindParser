<?php

namespace OpenMindParser\Models;

use \DOMDocument;

/*Object that represent the document itself. It is the entry point of the objects tree with all nodes.*/
class Document 
{
	/**
	 * @var String $path : The file path in the filesystem
	 */
	private $path;
	/**
	 * @var String $name : The file name (basename of the path).
	 */
	private $name;
	/**
	 * @var int $size : The file size.
	 */
	private $size;
	/**
	 * @var DOMDocument $domDocument : The DOMDocument instance of the loaded file.
	 */
	private $domDocument;
	/**
	 * @var Node $rootNode : The Node instance of the first Node of the file.
	 */
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
	
	/**
	 * Return the file path.
	 * 
	 * @return String : The file path.
	 */
	public function getPath() {
		return $this->path;
	}
	
	/**
	 * Set the file path.
	 * 
	 * @param String $path : The file path.
	 */
	public function setPath($path) {
		$this->path = $path;
	}
	
	/**
	 * Return the file name.
	 * 
	 * @return String : The file name.
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Set the file name.
	 * 
	 * @param String $name : The file name.
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Return the file size.
	 * 
	 * @return int : The file size.
	 */
	public function getSize() {
		return $this->size;
	}
	
	/**
	 * Set the file size.
	 * 
	 * @param int $size : The file size.
	 */
	public function setSize($size) {
		$this->size = $size;
	}
	
	/**
	 * Return the DOMDocument instance.
	 * 
	 * @return DOMDocument : The DOMDocument instance.
	 */
	public function getDomDocument() {
		return $this->domDocument;
	}
	
	/**
	 * Set the DOMDocument instance.
	 * 
	 * @param DOMDocument $domDocument : The DOMDocument instance.
	 */
	public function setDomDocument($domDocument) {
		$this->domDocument = $domDocument;
	}
	
	/**
	 * Return the root Node instance.
	 * 
	 * @return Node : The node instance.
	 */
	public function getRootNode() {
		return $this->rootNode;
	}
	
	/**
	 * Set the root Node instance.
	 * 
	 * @param Node $rootNode : The node instance.
	 */
	public function setRootNode($rootNode) {
		$this->rootNode = $rootNode;
	}
	
	/**
	 * To String method.
	 * 
	 * @return String : The name of the file.
	 */
	public function __toString() {
		return $this->getName();
	}
	
	/**
	 * Transform the objects tree in an array tree.
	 * 
	 * @return Array $array : The array tree.
	 */
	public function toArray() {
		$array = [];
		$sorter = function($value, $key) use(&$array) {
			if($value instanceof Node) {
				$value = $value->toArray();
			} elseif($value instanceof DOMDocument) {
				return;
			}
			$array[$key] = $value;
		};
		
		foreach(get_object_vars($this) as $key => $value) {
			$sorter($value, $key);
		}
		
		return $array;
	}
}