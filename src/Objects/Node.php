<?php

namespace OpenMindParser\Objects;

use \DOMNode;
use \DOMElement;
use \DOMNamedNodeMap;
use OpenMindParser\Exceptions\InvalidNodeNameException;

/*Object that represent a Node as the tag element in the openMind file.*/
class Node 
{
	/**
	 * @var String $id : The unique id of the node.
	 */
	private $id;
	/**
	 * @var String $color : The text color of the node.
	 */
	private $color;
	/**
	 * @var String $created : The timestamp of the creation date of the node.
	 */
	private $created;
	/**
	 * @var String $modified : The timestamp of the modified date of the node.
	 */
	private $modified;
	/**
	 * @var String $position : The relative position of the node.
	 */
	private $position;
	/**
	 * @var String $vshift : The vshift of the node.
	 */
	private $vshift;
	/**
	 * @var String $folded : Is the node folded or not.
	 */
	private $folded;
	/**
	 * @var String $text : The text of the node.
	 */
	private $text;
	/**
	 * @var String $fontName : The font name of the node.
	 */
	private $fontName;
	/**
	 * @var String $fontSize : The font size of the node.
	 */
	private $fontSize;
	/**
	 * @var NodeList $children : The children of the node as a collection of Nodes.
	 */
	private $children;
	/**
	 * @var DOMElement $domNode : The DOMElement instance of the current Node.
	 */
	private $domNode;
	
	/**
	 * @param DOMElement $domNode : The DOMElement instance of the current Node.
	 * @param NodeList $children : The children of the node as a collection of Nodes.
	 * @param String $id : The unique id of the node.
	 * @param String $color : The text color of the node.
	 * @param String $created : The timestamp of the creation date of the node.
	 * @param String $modified : The timestamp of the modified date of the node.
	 * @param String $position : The relative position of the node.
	 * @param String $vshift : The vshift of the node.
	 * @param String $folded : Is the node folded or not.
	 * @param String $text : The text of the node.
	 * @param String $fontName : The font name of the current Node.
	 * @param String $fontSize : The font size of the node.
	 */
	public function __construct(DOMElement $domNode = null, NodeList $children = null, $id = null, $color = null, $created = null, $modified = null, $position = null, $vshift = null, $folded = null, $text = null, $fontName = null, $fontSize = null) {
		$this->id = $id;
		$this->color = $color;
		$this->created = $created;
		$this->modified = $modified;
		$this->position = $position;
		$this->vshift = $vshift;
		$this->folded = $folded;
		$this->text = $text;
		$this->fontName = $fontName;
		$this->fontSize = $fontSize;
		$this->children = $children ?: new NodeList();
		$this->domNode = $domNode ?: new DOMElement();
	}
	
	/**
	 * Return the Id of the current node.
	 * 
	 * @param String $id : The node id.
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set the Id of the current node.
	 * 
	 * @param String $id : The node id.
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Return the color of the current node.
	 * 
	 * @param String $color : The node color value in hexadecimal.
	 */
	public function getColor() {
		return $this->color;
	}
	
	/**
	 * Set the color of the current node.
	 * 
	 * @param String $color : The node color value in hexadecimal.
	 */
	public function setColor($color) {
		$this->color = $color;
	}
	
	/**
	 * Return the created timestamp of the current node.
	 * 
	 * @param String $created : The node created timestamp.
	 */
	public function getCreated() {
		return $this->created;
	}
	
	/**
	 * Set the created timestamp of the current node.
	 * 
	 * @param String $created : The node created timestamp.
	 */
	public function setCreated($created) {
		$this->created = $created;
	}
	
	/**
	 * Return the modified timestamp of the current node.
	 * 
	 * @param String $modified : The node modified timestamp.
	 */
	public function getModified() {
		return $this->modified;
	}
	
	/**
	 * Set the modified timestamp of the current node.
	 * 
	 * @param String $modified : The node modified timestamp.
	 */
	public function setModified($modified) {
		$this->modified = $modified;
	}
	
	/**
	 * Return the relative position the current node to the parent node.
	 * 
	 * @param String $position : The node relative position.
	 */
	public function getPosition() {
		return $this->position;
	}
	
	/**
	 * Set the relative position the current node to the parent node.
	 * 
	 * @param String $position : The node relative position.
	 */
	public function setPosition($position) {
		$this->position = $position;
	}
	
	/**
	 * Return the vshift value of the current node.
	 * 
	 * @param String $vshift : The node vshift value.
	 */
	public function getVshift() {
		return $this->vshift;
	}
	
	/**
	 * Set the vshift value of the current node.
	 * 
	 * @param String $vshift : The node vshift value.
	 */
	public function setVshift($vshift) {
		$this->vshift = $vshift;
	}
	
	/**
	 * Return if the current node is folded or not.
	 * 
	 * @param Bool $folded
	 */
	public function isFolded() {
		return $this->folded;
	}
	
	/**
	 * Set if the current node is folded or not.
	 * 
	 * @param Bool $folded
	 */
	public function setFolded($folded) {
		$this->folded = $folded;
	}
	
	/**
	 * Return the text of the current node with html entities decoded.
	 * 
	 * @param String $text : The node text value.
	 */
	public function getText() {
		return html_entity_decode($this->text);
	}
	
	/**
	 * Return the text of the current node.
	 * 
	 * @param String $text : The node text value.
	 */
	public function getRawText() {
		return $this->text;
	}
	
	/**
	 * Set the text of the current node with html entities decoded.
	 * 
	 * @param String $text : The node text value in plain text not html encoded.
	 */
	public function setText($text) {
		$this->text = htmlentities($text);
	}
	
	/**
	 * Return the font name of the current node.
	 * 
	 * @param String $fontName : The node font name.
	 */
	public function getFontName() {
		return $this->fontName;
	}
	
	/**
	 * Set the font name of the current node.
	 * 
	 * @param String $fontName : The node font name.
	 */
	public function setFontName($fontName) {
		$this->fontName = $fontName;
	}
	
	/**
	 * Return the font size of the current node.
	 * 
	 * @param String $fontSize : The node font size.
	 */
	public function getFontSize() {
		return $this->fontSize;
	}
	
	/**
	 * Set the font size of the current node.
	 * 
	 * @param String $fontSize : The node font size.
	 */
	public function setFontSize($fontSize) {
		$this->fontSize = $fontSize;
	}
	
	/**
	 * Return the list of children of the current node.
	 * 
	 * @param NodeList $children : The list of children node.
	 */
	public function getChildren() {
		return $this->children;
	}
	
	/**
	 * Set the list of children of the current node.
	 * 
	 * @param NodeList $children : The list of children node.
	 */
	public function setChildren(NodeList $children) {
		$this->children = $children;
	}
	
	/**
	 * To String method.
	 * 
	 * @return String : The text content of the node.
	 */
	public function __toString() {
		return $this->getText();
	}
	
	/**
	 * Transform the objects tree in an array tree.
	 * 
	 * @return Array $array : The array tree.
	 */
	public function toArray() {
		$array = [];
		$sorter = function($value, $key) use(&$array) {
			if($value instanceof NodeList) {
				$newValue = [];
				foreach($value as $node) {
					$newValue[] = $node->toArray();
				}
				$value = $newValue;
			}
			elseif($value instanceof DOMElement) {
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