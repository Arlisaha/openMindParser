<?php

namespace OpenMindParser\Usage;

require __DIR__.'/../vendor/autoload.php';

use OpenMindParser\Parser;
use OpenMindParser\Converters\JSON\GenericJSONConverter;

$filePath = __DIR__.'/../tests/TestFile/Conduite_agressive.mm';

$htmlConverter = new GenericJSONConverter();
$str = $htmlConverter->convert($filePath);

echo'<pre>';
var_dump($str);
die;