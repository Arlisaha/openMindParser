<?php

namespace openMindParser\Converters;

interface ConverterInterface
{
	public static function convertFromFile($filePath);
	public static function convertFromDocumentInstance(Document $document);
}