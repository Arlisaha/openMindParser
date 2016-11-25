<?php

namespace openMindParser\Converters\HTML;

use openMindParser\Converters\Model\AbstractConverter;
use openMindParser\Objects\Document;
use openMindParser\Objects\Node;
use openMindParser\Parser;
use \DOMDocument;

/*A singleton to convert a document tree (object Document) in a HTML tree following few options.*/
class GenericHTMLConverter extends AbstractConverter
{
	/**
	 * @const String TAG_KEY : An option key name for the HTML tag to use.
	 */
	const TAG_KEY = 'tag';
	/**
	 * @const String ATTRIBUTES_KEY : An option key name for the HTML attributes to use on the tag.
	 */
	const ATTRIBUTES_KEY = 'attributes';
	
	/**
	 * Call the conversion over the Document instance.
	 * 
	 * @var Document $document : The document instance to convert.
	 * @var Array $options : The options for the conversion. 
	 * It must follow this filling : 
	 * [
	 * 		[
	 * 			TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 			ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 		],
	 * 		[
	 * 			TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 			ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 		],
	 * 		[
	 * 			TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 			ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 		],
	 * ]. The first two are mandatory, and the style stored in the Node instance (color, font name and font size) will be applied on the second tag).
	 * 
	 * @return DOMDocument $domDocument : The DOMDocument instance created with the HTML.
	 */
	protected function convertFromDocumentInstance(Document $document, array $options) {
		$domDocument = new DOMDocument();
		
		$domDocument->appendChild($this->buildHTMLTreeFromNode($domDocument, $document->getRootNode(), $options));
		
		return $domDocument;
	}
	
	/**
	 * Perform the conversion over the Document instance. 
	 * Each text will be wrap in at least two HTML tags (<ul><li>, <div><span>, ...) and at most three tags (<ul><li><span>, ...).
	 * The style stored in the Node instance (color, font name and font size) will be applied on the second tag and override the "style" attribute if one is given.
	 * 
	 * @var Document $document : The document instance to convert.
	 * @var Array $options : The options for the conversion. 
	 * It must follow this filling : 
	 * [
	 * 		[
	 * 			TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 			ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 		],
	 * 		[
	 * 			TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 			ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 		],
	 * 		[
	 * 			TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 			ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 		],
	 * ]. The first two are mandatory.
	 * 
	 * @return DOMDocument $domDocument : The DOMDocument instance created with the HTML.
	 */
	private function buildHTMLTreeFromNode(DOMDocument $document, Node $node, array $options) {
		$domElementA = $this->buildElement($document, $options[0]);
		
		$options[1][self::ATTRIBUTES_KEY] = array_merge([$options[1][self::ATTRIBUTES_KEY], 
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
	
	/**
	 * Build the HTML tag following its given tag name and attributes stored in $description array.
	 * 
	 * @param DOMDocument $document : The current DOMDocument in creation with the HTML tree.
	 * @param array $description : The array describing the tag to create.
	 * 
	 * @return DOMElement $domElement : The created DOMElement.
	 */
	private function buildElement(DOMDocument $document, array $description) {
		$domElement = $document->createElement($description[self::TAG_KEY]);
		foreach($description[self::ATTRIBUTES_KEY] as $name => $attribute) {
			$domElement->setAttribute($name, $attribute);
		}
		
		return $domElement;
	}
}