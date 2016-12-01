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
	 * String MAIN_TAG_KEY : An option key name for the list of HTML tags to use.
	 */
	const MAIN_TAG_KEY = 'tags';
	/**
	 * String TAG_KEY : An option key name for the HTML tag to use.
	 */
	const TAG_KEY = 'tag'; 
	/**
	 * String ATTRIBUTES_KEY : An option key name for the HTML attributes to use on the tag.
	 */
	const ATTRIBUTES_KEY = 'attributes';
	/**
	 * String MAIN_ICON_KEY : An option key name for the icon tag to use.
	 */
	const MAIN_ICON_KEY = 'icon'; 
	/**
	 * String DISPLAY_ICON_KEY : A boolean to determine if for nodes with an icon, the icon will be added in a img tag before the text.
	 */
	 const DISPLAY_ICON_KEY = 'display';
	/**
	 * String PATH_ICON_KEY : A boolean to determine if for nodes with an icon, the icon will be added in a img tag before the text.
	 */
	 const PATH_ICON_KEY = 'path';
	
	/**
	 * Call the conversion over the Document instance.
	 * 
	 * @var Document $document : The document instance to convert.
	 * @var Array $options : The options for the conversion. 
	 * It must follow this filling : 
	 * [
	 * 		MAIN_TAG_KEY =>
	 * 			[
	 * 				TAG_KEY        => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 			[
	 * 				TAG_KEY        => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 			[
	 * 				TAG_KEY        => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 		MAIN_ICON_KEY => [
	 * 			DISPLAY_ICON_KEY => boolean determining if the icons must be displayed or not,
	 * 			PATH_ICON_KEY    => 'optional path to use instead of the short uri for img rendering.',
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
	 * 		MAIN_TAG_KEY =>
	 * 			[
	 * 				TAG_KEY        => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 			[
	 * 				TAG_KEY        => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 			[
	 * 				TAG_KEY        => 'HTML tag to use (ul, div, ...)',
	 * 				ATTRIBUTES_KEY => ['attribute name (class, id, href, ...)' => 'attribute value', ...]
	 * 			],
	 * 		MAIN_ICON_KEY => [
	 * 			DISPLAY_ICON_KEY => boolean determining if the icons must be displayed or not,
	 * 			PATH_ICON_KEY    => 'optional path to use instead of the short uri for img rendering.',
	 * 		],
	 * ]. The first two are mandatory.
	 * 
	 * @return DOMDocument $domDocument : The DOMDocument instance created with the HTML.
	 */
	private function buildHTMLTreeFromNode(DOMDocument $document, Node $node, array $options) {
		$domElementA = $this->buildElement($document, $options[self::MAIN_TAG_KEY][0]);
		
		$options[self::MAIN_TAG_KEY][1][self::ATTRIBUTES_KEY] = array_merge(
			$options[self::MAIN_TAG_KEY][1][self::ATTRIBUTES_KEY], [
			'style' => 'color:'.$node->getColor().';'.
					   ($node->getFontName() ? 'font-family:'.$node->getFontName().';' : '').
					   ($node->getFontSize() ? 'font-size:'.$node->getFontSize().';' : ''),
			'id'    => $node->getId(),
			]);
		$domElementB = $this->buildElement($document, $options[self::MAIN_TAG_KEY][1]);
		
		if(!empty($node->getIcon()) && $options[self::MAIN_ICON_KEY][self::DISPLAY_ICON_KEY]) {
			$icon = $node->getIcon();
			$domElementImg = $document->createElement('img');
			$domElementImg->setAttribute(
				'src', 
				array_key_exists(self::PATH_ICON_KEY, $options[self::MAIN_ICON_KEY]) ? 
					$options[self::MAIN_ICON_KEY][self::PATH_ICON_KEY].$icon->getFullName() :
					$icon->getShortUri()
			);
			$domElementImg->setAttribute('alt', $icon->getName());
			$domElementB->appendChild($domElementImg);
		}
		
		$text = $document->createTextNode($node->getText());
		if(isset($options[self::MAIN_TAG_KEY][2])) {
			$domElementC = $this->buildElement($document, $options[self::MAIN_TAG_KEY][2]);
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
		$domElement = $document->createElement($description[self::TAG_KEY]);
		foreach($description[self::ATTRIBUTES_KEY] as $name => $attribute) {
			$domElement->setAttribute($name, $attribute);
		}
		
		return $domElement;
	}
}