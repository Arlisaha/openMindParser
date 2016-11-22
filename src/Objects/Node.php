<?php

namespace openMindParser\Objects;

use \DOMNode;
use \DOMNamedNodeMap;
use openMindParser\Exceptions\InvalidNodeNameException;

class Node 
{
	private $id;
	private $color;
	private $created;
	private $modified;
	private $position;
	private $vshift;
	private $folded;
	private $text;
	private $fontName;
	private $fontSize;
	private $children;
	private $domNode;
	
	/**
	 * Build the Node object and all its children following the given DOMNode object.
	 * 
	 * @param \DOMNode $node : The DOMNode with name NODE_NODENAME to be representend in an object.
	 */
	public function __construct(DOMNode $domNode = null, NodeList $children = null, $id = null, $color = null, $created = null, $modified = null, $position = null, $vshift = null, $folded = null, $text = null, $fontName = null, $fontSize = null) {
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
		$this->children = $children;
		$this->domNode = $domNode;
	}
	
	/**
	 * Return the Id of the current node.
	 * 
	 * @param String $id : The node id.
	 */
	public function getId() {
		return $this->id;
	}
	
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
	
	public function setFolded($folded) {
		$this->folded = $folded;
	}
	
	/**
	 * Return the text of the current node.
	 * 
	 * @param String $text : The node text value.
	 */
	public function getText() {
		return $this->text;
	}
	
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
	
	public function setChildren(NodeList $children) {
		$this->children = $children;
	}
}