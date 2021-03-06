<?php

namespace OpenMindParser;

use OpenMindParser\Models\Document;
use OpenMindParser\Models\Node;
use OpenMindParser\Models\Icon;
use OpenMindParser\Models\NodeList;
use \InvalidArgumentException;
use \DOMDocument;
use \DOMElement;
use \DOMNamedNodeMap;

/*The class responsible to build the objects tree representing the openMind document.*/
class Parser
{
	/**
	 * @const String NODE_NODENAME : a constant with the name of the XML node with data to store.
	 */
	const NODE_NODENAME = 'node';
	/**
	 * @var Array $nodeAvailableAttributes : list of available attributes in XML tag NODE_NODENAME.
	 */
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
	/**
	 * @const String FONT_NODENAME : a constant with the name of the XML node with data to store for font matter.
	 */
	const FONT_NODENAME = 'font';
	/**
	 * @var Array $fontAvailableAttributes : list of available attributes in XML tag FONT_NODENAME.
	 */
	private static $fontAvailableAttributes = [
		'NAME'   => 'fontName',
		'SIZE'   => 'fontSize',
		'BOLD'   => 'bold',
		'ITALIC' => 'italic',
	];
	/**
	 * @const String ICON_NODENAME : a constant with the name of the XML node with data to store for icon matter.
	 */
	const ICON_NODENAME = 'icon';
	/**
	 * @var Array $iconAvailableAttributes : list of available attributes in XML tag ICON_NODENAME.
	 */
	private static $iconAvailableAttributes = [
		'BUILTIN' => 'icon',
	];
	
	/**
	 * Build the document tree (all objects) out of the file given in parameter.
	 * 
	 * @param String $filePath : The path to the openMind file.
	 * 
	 * @return Document : The document instance with all its nodes instances.
	 */
	public function buildDocumentTreeFromFilePath($filePath) {
		if(!file_exists($filePath)) {
			throw new InvalidArgumentException('The given path : "'.$filePath.'" is invalid.');
		}
		
		$domDocument = new DOMDocument();
		$domDocument->load($filePath);
		
		//Get the first node named 'self::NODE_NODENAME' and make a Node object out of it.
		$rootNode = $this->fillNode($domDocument->getElementsByTagName(self::NODE_NODENAME)->item(0));
		
		return new Document($domDocument, $rootNode, $filePath, basename($filePath), filesize($filePath));
	}
	
	/**
	 * Create and fill the node instance with all the data stored in the XML file
	 * 
	 * @param DOMElement $domNode : The current XML 'node' element to build the Node object.
	 * 
	 * @return Node : The created Node (and all its children).
	 */
	private function fillNode(DOMElement $domNode) {
		//The given node name must be self::NODE_NODENAME
		if($domNode->nodeName !== self::NODE_NODENAME) {
			throw new InvalidNodeNameException('The node name must be "node". "'.$domNode->nodeName.'" given.');
		}
		
		$node = new Node($domNode);
		
		$this->fillNodeAttributes($domNode->attributes, self::$nodeAvailableAttributes, $node);
		
		//Build the list of children nodes and fill font information.
		$children = new NodeList();
		foreach($domNode->childNodes as $childNode) {
			if($childNode->nodeName === self::NODE_NODENAME) {
				$children->add($this->fillNode($childNode));
			} elseif($childNode->nodeName === self::FONT_NODENAME) {
				$this->fillNodeAttributes($childNode->attributes, self::$fontAvailableAttributes, $node);
			} elseif($childNode->nodeName === self::ICON_NODENAME) {
				foreach($childNode->attributes as $attribute) {
					if(array_key_exists($attribute->nodeName, self::$iconAvailableAttributes)) {
						$node->setIcon(new Icon($attribute->nodeValue));
					}
				}
			}
		}
		
		$node->setChildren($children);
		
		return $node;
	}
	
	/**
	 * For each attribute whom the name is the keys of $availableAttributes, its value will be put in the matching attribute.
	 * 
	 * @param DOMNamedNodeMap $nodeAtributes : The list of attributes of the current node to fill the Node object.
	 * @param array $availableAttributes : One of the static array of this class to describe the list of known attributes.
	 * @param Node $node : The Node object to fill in.
	 */
	private function fillNodeAttributes (DOMNamedNodeMap $nodeAtributes, array $availableAttributes, Node $node) {
		foreach($nodeAtributes as $attribute) {
			if(array_key_exists($attribute->nodeName, $availableAttributes)) {
				call_user_func([
						$node, 
						sprintf('openMindParser\Models\Node::set%s', ucfirst($availableAttributes[$attribute->nodeName]))
					], 
					json_decode($attribute->nodeValue) ?: $attribute->nodeValue
				);
			}
		}
	}
}