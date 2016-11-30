<?php

namespace OpenMindParser\Usage;

require __DIR__.'/../vendor/autoload.php';

use OpenMindParser\Parser;

$filePath = __DIR__.'/../tests/TestFile/Conduite_agressive.mm';

$parser = new Parser();
$doc = $parser->buildDocumentTreeFromFilePath($filePath);

echo('<pre>');
var_dump($doc);
die;