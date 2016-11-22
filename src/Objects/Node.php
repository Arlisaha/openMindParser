<?php

namespace openMindParser\Objects;

use openMindParser\Exceptions\InvalidNodeNameException;

class Node 
{
	const NODE_NODENAME = 'node';
	private static $nodeAvailableAttributes = [
		'ID'       => 'id',
		'COLOR'    => 'color',
		'CREATED'  => 'created',
		'MODIFIED' => 'modified',
		'POSITION' => 'position',
		'VSHIFT'   => 'vshift',
		'FOLDED'   => 'folded',
		'TEXT'     => 'text',
	];
	const FONT_NODENAME = 'font';
	private static $fontAvailableAttributes = [
		'NAME' => 'fontName',
		'SIZE' => 'fontSize',
	];
	
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
	
	/**
	 * Build the Node object and all its children followinf the given DOMNode object.
	 * 
	 * @param \DOMNode $node : The DOMNode with name NODE_NODENAME to be representend in an object.
	 */
	public function __construct(\DOMNode $node = null) {
		if(!empty($node)) {
			$this->setAllAttributesFromNode($node);
		}
	}
	
	/**
	 * Fill all class attributes according to the data stored in the given DOMNode instance.
	 * 
	 * @param \DOMNode $node : The DOMNode with name NODE_NODENAME to be representend in an object.
	 */
	public function setAllAttributesFromNode(\DOMNode $node) {
		/*The given node name must be self::NODE_NODENAME*/
		if($node->nodeName !== self::NODE_NODENAME) {
			throw new InvalidNodeNameException('The node name must be "node". "'.$node->nodeName.'" given.');
		}
		
		/*For each attribute whom the name is the keys of $availableAttributes, its value will be put in the matching attribute.*/
		$fillAttributes = function(\DOMNamedNodeMap $nodeAtributes, array $availableAttributes) {
			foreach($nodeAtributes as $attribute) {
				if(array_key_exists($attribute->nodeName, $availableAttributes)) {
					$this->$availableAttributes[$attribute->nodeName] = $attribute->nodeValue;
				}
			}
		}
		
		
		$fillAttributes($node->attributes, self::$nodeAvailableAttributes);
		
		/*Build the list of children nodes and fill font information.*/
		$this->children = new NodeList();
		foreach($node->childNodes as $child) {
			if($child->nodeName === self::NODE_NODENAME) {
				$this->children->add(new Node($child));
			}
			elseif($child->nodeName === self::FONT_NODENAME) {
				$fillAttributes($node->attributes, self::$fontAvailableAttributes);
			}
		}
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
	 * Return the color of the current node.
	 * 
	 * @param String $color : The node color value in hexadecimal.
	 */
	public function getColor() {
		return $this->color;
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
	 * Return the modified timestamp of the current node.
	 * 
	 * @param String $modified : The node modified timestamp.
	 */
	public function getModified() {
		return $this->modified;
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
	 * Return the vshift value of the current node.
	 * 
	 * @param String $vshift : The node vshift value.
	 */
	public function getVshift() {
		return $this->vshift;
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
	
	/**
	 * Return the font size of the current node.
	 * 
	 * @param String $fontSize : The node font size.
	 */
	public function getFontSize() {
		return $this->fontSize;
	}
	
	/**
	 * Return the list of children of the current node.
	 * 
	 * @param NodeList $children : The list of children node.
	 */
	public function getChildren() {
		return $this->children;
	}
}