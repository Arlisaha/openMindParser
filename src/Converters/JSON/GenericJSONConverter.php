<?php

namespace openMindParser\Converters\JSON;

use openMindParser\Converters\Model\AbstractConverter;
use openMindParser\Objects\Document;
use openMindParser\Objects\Node;
use openMindParser\Parser;
use \DOMDocument;

/*A singleton to convert a document tree (object Document) in a JSON tree following few options.*/
class GenericJSONConverter extends AbstractConverter
{
	protected function convertFromDocumentInstance(Document $document, array $options) {
		return json_encode($document->toArray());
	}
}