<?php

namespace openMindParser\Tests\Objects;

use \PHPUnit_Framework_TestCase as TestCase;
use OpenMindParser\Parser;
use \DOMDocument;

class DocumentTest extends TestCase
{
	public function testToArray() {
		$filePath = __DIR__.'/../TestFile/test_sample.mm';
		$awaitedResult = [
			'path'     => $filePath,
			'name'     => basename($filePath),
			'size'     => filesize($filePath),
			'rootNode' => [
				'id'       => '0',
				'color'    => '#000000', 
				'created'  => '0000000000000',
				'modified' => '0000000000000',
				'position' => null,
				'vshift'   => null,
				'folded'   => null,
				'text'     => 'node_0',
				'fontName' => 'SansSerif',
				'fontSize' => '20',
				'children' => [
					[	
						'id'       => '0_1',
						'color'    => '#010101', 
						'created'  => '0000000000000',
						'modified' => '0000000000000',
						'position' => 'right',
						'vshift'   => '-45',
						'folded'   => 'true',
						'text'     => 'node_0_1',
						'fontName' => 'SansSerif',
						'fontSize' => '18',
						'children' => [
							[
								'id'       => '0_1_1',
								'color'    => '#011011', 
								'created'  => '0000000000000',
								'modified' => '0000000000000',
								'position' => null,
								'vshift'   => null,
								'folded'   => null,
								'text'     => 'node_0_1_1',
								'fontName' => 'SansSerif',
								'fontSize' => '16',
								'children' => [],
							],
						],
					],
					[
						'id'       => '0_2',
						'color'    => '#020202', 
						'created'  => '0000000000000',
						'modified' => '0000000000000',
						'position' => 'right',
						'vshift'   => '-45',
						'folded'   => 'true',
						'text'     => 'node_0_2',
						'fontName' => null,
						'fontSize' => null,
						'children' => [],
					],
				],
			],
		];
		
		$doc = Parser::getInstance();
		$doc = $doc->buildDocumentTreeFromFilePath($filePath);
		
		$this->assertEquals($awaitedResult, $doc->toArray());
	}
}