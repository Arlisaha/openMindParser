<?php

namespace OpenMindParser\Converters\HTML;

use OpenMindParser\Converters\Model\AbstractConverter;
use OpenMindParser\Models\Document;
use OpenMindParser\Models\Node;
use OpenMindParser\Parser;
use \DOMDocument;

/*A singleton to convert a document tree (object Document) in a HTML tree following few options.*/
class GenericHTMLConverter extends AbstractConverter
{
	/**
	 * Call the conversion over the Document instance.
	 * 
	 * @var Document $document : The document instance to convert.
	 * @var Array $options : The options for the conversion. 
	 * It must follow this filling : 
	 * [
	 * 		'tags' =>
	 * 			[
	 * 				TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 			[
	 * 				TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 			[
	 * 				TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 		'icon' => boolean determining if the icons must be displayed or not,
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
	 * 		'tags' => [
	 * 			[
	 * 				TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 			[
	 * 				TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 			[
	 * 				TAG_KEY => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 		],
	 * 		'icon' => boolean determining if the icons must be displayed or not,
	 * ]. The first two are mandatory.
	 * 
	 * @return DOMDocument $domDocument : The DOMDocument instance created with the HTML.
	 */
	private function buildHTMLTreeFromNode(DOMDocument $document, Node $node, array $options) {
		$domElementA = $this->buildElement($document, $options[HTML_CONVERTER_MAIN_TAG_KEY][0]);
		
		$options[HTML_CONVERTER_MAIN_TAG_KEY][1][HTML_CONVERTER_ATTRIBUTES_KEY] = array_merge([$options[HTML_CONVERTER_MAIN_TAG_KEY][1][HTML_CONVERTER_ATTRIBUTES_KEY], 
			'style' => 'color:'.$node->getColor().';'.
					   ($node->getFontName() ? 'font-family:'.$node->getFontName().';' : '').
					   ($node->getFontSize() ? 'font-size:'.$node->getFontSize().';' : ''),
			'id'    => $node->getId(),
			]);
		$domElementB = $this->buildElement($document, $options[HTML_CONVERTER_MAIN_TAG_KEY][1]);
		
		if(!empty($node->getIcon()) && $options[HTML_CONVERTER_MAIN_ICON_KEY]) {
			$icon = $node->getIcon();
			$domElementImg = $document->createElement('img');
			$domElementImg->setAttribute('src', $icon->getFilePath());
			$domElementImg->setAttribute('alt', $icon->getName());
			$domElementB->appendChild($domElementImg);
		}
		
		$text = $document->createTextNode($node->getText());
		if(isset($options[HTML_CONVERTER_MAIN_TAG_KEY][2])) {
			$domElementC = $this->buildElement($document, $options[HTML_CONVERTER_MAIN_TAG_KEY][2]);
			$domElementC->appendChild($text);
			$domElementB->appendChild($domElementC);
		}
		else {
			$domElementB->appendChild($text);
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
		$domElement = $document->createElement($description[HTML_CONVERTER_TAG_KEY]);
		foreach($description[HTML_CONVERTER_ATTRIBUTES_KEY] as $name => $attribute) {
			$domElement->setAttribute($name, $attribute);
		}
		
		return $domElement;
	}
}