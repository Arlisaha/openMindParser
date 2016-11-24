<?php

namespace openMindParser\Converters\Model;

use openMindParser\Objects\Document;
use openMindParser\Parser;
use \InvalidArgumentException;

abstract class AbstractConverter implements ConverterInterface
{
	public static function convert($data, $options = []) {
		if(!is_string($data) || !($data instanceof Document)) {
			throw new InvalidArgumentException('The $data variable must be of type "string" (the file path), or an instance of "Document".');
		}
		elseif(!is_array($options)) {
			throw new InvalidArgumentException('The $options variable must be and array.');
		}
		
		if(is_string($data)) {
			$document = Parser::buildDocumentTreeFromFilePath($filePath);	
		}
		
		return self::convertFromDocumentInstance($document, $options);
	}
	
	private static function convertFromDocumentInstance(Document $document, array $options);
}