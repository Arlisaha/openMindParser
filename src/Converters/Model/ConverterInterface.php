<?php

namespace openMindParser\Converters\Model;

interface ConverterInterface
{
	public static function convertFromFile($filePath);
	public static function convertFromDocumentInstance(Document $document);
}