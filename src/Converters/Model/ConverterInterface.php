<?php

namespace openMindParser\Converters\Model;

interface ConverterInterface
{
	public static function convertFromFile($filePath, array $options = []);
	public static function convertFromDocumentInstance(Document $document, array $options = []);
}