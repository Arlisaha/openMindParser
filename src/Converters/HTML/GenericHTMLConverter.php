<?php

namespace openMindParser\Converters\HTML;

use openMindParser\Converters\Model\AbstractConverter;
use openMindParser\Objects\Document;
use openMindParser\Objects\Node;
use openMindParser\Parser;
use \DOMDocument;

/**
 * A singleton to convert a document tree (object Document) in a HTML tree following few options.
 */
class GenericHTMLConverter extends AbstractConverter
{
	const TAG_KEY = 'tag';
	const ATTRIBUTES_KEY = 'attributes';
	
	protected function convertFromDocumentInstance(Document $document, array $options) {
		$domDocument = new DOMDocument();
		
		$domDocument->appendChild($this->buildHTMLTreeFromNode($domDocument, $document->getRootNode(), $options));
		
		return $domDocument;
	}
	
	private function buildHTMLTreeFromNode(DOMDocument $document, Node $node, array $options) {
		$domElementA = $this->buildElement($document, $options[0]);
		
		$options[1][self::ATTRIBUTES_KEY] = array_merge([$options[1]['attributes'], 
			'style' => 'color:'.$node->getColor().';'.
					   ($node->getFontName() ? 'font-family:'.$node->getFontName().';' : '').
					   ($node->getFontSize() ? 'font-size:'.$node->getFontSize().';' : ''),
			]);
		$domElementB = $this->buildElement($document, $options[1]);
		
		$text = $node->getText();
		if(isset($options[2])) {
			$domElementC = $this->buildElement($document, $options[2]);
			$domElementC->textContent = $text;
			$domElementB->appenChild($domElementC);
		}
		else {
			$domElementB->textContent = $text;
		}
		
		$domElementA->appendChild($domElementB);
		
		foreach($node->getChildren() as $child) {
			$domElementB->appendChild($this->buildHTMLTreeFromNode($document, $child, $options));
		}
		
		return $domElementA;
	}
	
	private function buildElement(DOMDocument $document, array $description) {
		$domElement = $document->createElement($description[self::TAG_KEY]);
		foreach($description[self::ATTRIBUTES_KEY] as $name => $attribute) {
			$domElement->setAttribute($name, $attribute);
		}
		
		return $domElement;
	}
}