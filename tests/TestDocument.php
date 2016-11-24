<?php

namespace openMindParser\Tests;

require __DIR__.'/../vendor/autoload.php';

use openMindParser\Parser;

$filePath = __DIR__.'/TestFile/Conduite_agressive.mm';

$doc = Parser::getInstance();
$doc = $doc->buildDocumentTreeFromFilePath($filePath);

echo('<pre>');
var_dump($doc);
die;