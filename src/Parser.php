<?php

namespace openMindParser;

use openMindParser\Objects\Document;
use openMindParser\Objects\Node;
use openMindParser\Objects\NodeList;
use \DOMDocument;
use \DOMElement;
use \DOMNamedNodeMap;

class Parser
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
	
	public static function buildDocumentTreeFromFilePath($filePath) {
		if(!file_exists($filePath)) {
			throw new \InvalidArgumentException('The given path : "'.$filePath.'" is invalid.');
		}
		
		$domDocument = new DOMDocument();
		$domDocument->load($filePath);
		
		//Get the first node named 'self::NODE_NODENAME' and make a Node object out of it.
		$rootNode = self::fillNode($domDocument->getElementsByTagName(self::NODE_NODENAME)->item(0));
		
		return new Document($domDocument, $rootNode, $filePath, basename($filePath), filesize($filePath));
	}
	
	private static function fillNode(DOMElement $domNode) {
		//The given node name must be self::NODE_NODENAME
		if($domNode->nodeName !== self::NODE_NODENAME) {
			throw new InvalidNodeNameException('The node name must be "node". "'.$domNode->nodeName.'" given.');
		}
		
		$node = new Node();
		
		self::fillNodeAttributes($domNode->attributes, self::$nodeAvailableAttributes, $node);
		
		/*Build the list of children nodes and fill font information.*/
		$children = new NodeList();
		foreach($domNode->childNodes as $childNode) {
			if($childNode->nodeName === self::NODE_NODENAME) {
				$children->add(self::fillNode($childNode));
			}
			elseif($childNode->nodeName === self::FONT_NODENAME) {
				self::fillNodeAttributes($domNode->attributes, self::$fontAvailableAttributes, $node);
			}
		}
		
		$node->setChildren($children);
		
		return $node;
	}
	
	/*For each attribute whom the name is the keys of $availableAttributes, its value will be put in the matching attribute.*/
	private static function fillNodeAttributes (DOMNamedNodeMap $nodeAtributes, array $availableAttributes, Node $node) {
		foreach($nodeAtributes as $attribute) {
			if(array_key_exists($attribute->nodeName, $availableAttributes)) {
				call_user_func([$node, sprintf('openMindParser\Objects\Node::set%s', ucfirst($availableAttributes[$attribute->nodeName]))], $attribute->nodeValue);
			}
		}
	}
}