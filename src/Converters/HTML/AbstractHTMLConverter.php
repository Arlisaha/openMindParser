<?php

namespace openMindParser\Converters\HTML;

use openMindParser\Converters\Model\AbstractConverter;
use openMindParser\Objects\Document;
use openMindParser\Parser;

abstract class AbstractHTMLConverter extends AbstractConverter
{
	public static function convertFromFile($filePath) {
		return self::convertFromDocumentInstance(Parser::buildDocumentTreeFromFilePath($filePath));
	}
	
	public static function convertFromDocumentInstance(Document $document) {
		
	}
	
	private static function doConvert() {
		
	}
}