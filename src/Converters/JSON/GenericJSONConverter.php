<?php

namespace OpenMindParser\Converters\JSON;

use OpenMindParser\Converters\Model\AbstractConverter;
use OpenMindParser\Models\Document;
use OpenMindParser\Models\Node;
use OpenMindParser\Parser;
use \DOMDocument;

/*A singleton to convert a document tree (object Document) in a JSON tree following few options.*/
class GenericJSONConverter extends AbstractConverter
{
	/**
	 * Perform the ocnversion in JSON by exporting the objects tree in an array tree and converting it in JSON.
	 * 
	 * @param Document $document : The Document instance to write in JSON.
	 * @param array $options : The options to perform the conversion.
	 * 
	 * @return String : The JSON string.
	 */
	protected function convertFromDocumentInstance(Document $document, array $options) {
		return json_encode($document->toArray());
	}
}