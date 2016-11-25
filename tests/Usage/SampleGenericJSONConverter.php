<?php

namespace openMindParser\Tests\Usage;

require __DIR__.'/../../vendor/autoload.php';

use openMindParser\Parser;
use openMindParser\Converters\JSON\GenericJSONConverter;

$filePath = __DIR__.'/../TestFile/Conduite_agressive.mm';

$htmlConverter = GenericJSONConverter::getInstance();
$str = $htmlConverter->convert($filePath);

echo'<pre>';
var_dump($str);
die;