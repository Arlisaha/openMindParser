<?php

namespace openMindParser\Tests\Converters;

use \PHPUnit_Framework_TestCase as TestCase;
use OpenMindParser\Converters\JSON\GenericJSONConverter;

class GenericJSONConverterTest extends TestCase
{
	public function testConvert() {
		$filePath = __DIR__.'/../TestFile/test_sample.mm';
		$awaitedJson = json_encode(
			[
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
				'icon'     => null,
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
						'icon'     => null,
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
								'fontName' => null,
								'fontSize' => null,
								'icon'     => null,
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
						'fontName' => 'SansSerif',
						'fontSize' => '16',
						'icon'     => '/img/button_ok.png',
						'children' => [],
					],
				],
			],
		]
		);
		$jsonConverter = new GenericJSONConverter();
		
		$jsonStr = $jsonConverter->convert($filePath);
		
		$this->assertEquals($awaitedJson, $jsonStr);
	}
}