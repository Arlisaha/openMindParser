<?php

namespace OpenMindParser\Usage;

require __DIR__.'/../vendor/autoload.php';

use OpenMindParser\Parser;
use OpenMindParser\Converters\HTML\GenericHTMLConverter;

$filePath = __DIR__.'/../tests/TestFile/Conduite_agressive.mm';

$htmlConverter = new GenericHTMLConverter();
$str = $htmlConverter->convert($filePath, [
	GenericHTMLConverter::MAIN_TAG_KEY => [
		[GenericHTMLConverter::TAG_KEY => 'ul', GenericHTMLConverter::ATTRIBUTES_KEY => []], 
		[GenericHTMLConverter::TAG_KEY => 'li', GenericHTMLConverter::ATTRIBUTES_KEY => []],
	], 
	GenericHTMLConverter::MAIN_ICON_KEY => [
		GenericHTMLConverter::DISPLAY_ICON_KEY => true,
		GenericHTMLConverter::PATH_ICON_KEY    => [
			GenericHTMLConverter::CALLBACK_PATH_ICON_KEY => function($fullName, $options = null){return '/openMindParser/img/'.$fullName;},
		],
	],
]);

echo'<pre>';
var_dump($str->saveHTML());
die;