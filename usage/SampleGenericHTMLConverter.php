<?php

namespace openMindParser\Usage;

require __DIR__.'/../vendor/autoload.php';

use openMindParser\Parser;
use openMindParser\Converters\HTML\GenericHTMLConverter;

$filePath = __DIR__.'/../tests/TestFile/Conduite_agressive.mm';

$htmlConverter = GenericHTMLConverter::getInstance();
$str = $htmlConverter->convert($filePath, [['tag' => 'ul', 'attributes' =>[]], ['tag' => 'li', 'attributes' =>[]]]);

echo'<pre>';
var_dump($str->saveHTML());
die;