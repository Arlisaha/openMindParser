<?php

namespace openMindParser\Converters\Model;

use openMindParser\Objects\Document;
use openMindParser\Parser;

abstract class AbstractConverter implements ConverterInterface
{
	public static function convertFromFile($filePath) {
		return self::convertFromDocumentInstance(Parser::buildDocumentTreeFromFilePath($filePath));
	}
	
	public static function convertFromDocumentInstance(Document $document);
}