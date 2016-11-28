<?php

namespace OpenMindParser\Usage;

require __DIR__.'/../vendor/autoload.php';

use OpenMindParser\Parser;
use OpenMindParser\Converters\HTML\GenericHTMLConverter;

$filePath = __DIR__.'/../tests/TestFile/Conduite_agressive.mm';

$htmlConverter = GenericHTMLConverter::getInstance();
$str = $htmlConverter->convert($filePath, [
	HTML_CONVERTER_MAIN_TAG_KEY => [
		[HTML_CONVERTER_TAG_KEY => 'ul', HTML_CONVERTER_ATTRIBUTES_KEY =>[]], 
		[HTML_CONVERTER_TAG_KEY => 'li', HTML_CONVERTER_ATTRIBUTES_KEY =>[]],
	], 
	HTML_CONVERTER_MAIN_ICON_KEY => true,
]);

echo'<pre>';
var_dump($str->saveHTML());
die;