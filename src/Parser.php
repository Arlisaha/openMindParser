<?php

namespace openMindParser;

use openMindParser\Patterns\AbstractSingleton;
use openMindParser\Objects\Document;
use openMindParser\Objects\Node;
use openMindParser\Objects\NodeList;
use \DOMDocument;
use \DOMElement;
use \DOMNamedNodeMap;

/*The class responsible to build the objects tree representing the openMind document.*/
class Parser extends AbstractSingleton
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
	
	/**
	 * Build the document tree (all objects) out of the file given in parameter.
	 * 
	 * @param String $filePath : The path to the openMind file.
	 * 
	 * @return Document : The document instance with all its nodes instances.
	 */
	public function buildDocumentTreeFromFilePath($filePath) {
		if(!file_exists($filePath)) {
			throw new \InvalidArgumentException('The given path : "'.$filePath.'" is invalid.');
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
		
		$node = new Node();
		
		$this->fillNodeAttributes($domNode->attributes, self::$nodeAvailableAttributes, $node);
		
		//Build the list of children nodes and fill font information.
		$children = new NodeList();
		foreach($domNode->childNodes as $childNode) {
			if($childNode->nodeName === self::NODE_NODENAME) {
				$children->add($this->fillNode($childNode));
			}
			elseif($childNode->nodeName === self::FONT_NODENAME) {
				$this->fillNodeAttributes($domNode->attributes, self::$fontAvailableAttributes, $node);
			}
		}
		
		$node->setChildren($children);
		
		return $node;
	}
	
	/**
	 * For each attribute whom the name is the keys of $availableAttributes, its value will be put in the matching attribute.
	 * 
	 * @param DOMNamedNodeMap $nodeAttributes : The list of attributes of the current node to fill the Node object.
	 * @param array $availableAttributes : One of the static array of this class to describe the list of known attributes.
	 * @param Node $node : The Node object to fill in.
	 */
	private function fillNodeAttributes (DOMNamedNodeMap $nodeAtributes, array $availableAttributes, Node $node) {
		foreach($nodeAtributes as $attribute) {
			if(array_key_exists($attribute->nodeName, $availableAttributes)) {
				call_user_func([$node, sprintf('openMindParser\Objects\Node::set%s', ucfirst($availableAttributes[$attribute->nodeName]))], $attribute->nodeValue);
			}
		}
	}
}