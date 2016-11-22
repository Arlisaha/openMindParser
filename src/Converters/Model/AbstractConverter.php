<?php

namespace openMindParser\Converters\Model;

use openMindParser\Objects\Document;
use openMindParser\Parser;

abstract class AbstractConverter implements ConverterInterface
{
	public static function convertFromFile($filePath, array $options = []) {
		return self::convertFromDocumentInstance(Parser::buildDocumentTreeFromFilePath($filePath), $options = []);
	}
	
	public static function convertFromDocumentInstance(Document $document, array $options = []);
}