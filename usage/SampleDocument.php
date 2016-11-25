<?php

namespace OpenMindParser\Usage;

require __DIR__.'/../vendor/autoload.php';

use OpenMindParser\Parser;

$filePath = __DIR__.'/../tests/TestFile/Conduite_agressive.mm';

$doc = Parser::getInstance();
$doc = $doc->buildDocumentTreeFromFilePath($filePath);

echo('<pre>');
var_dump($doc);
die;