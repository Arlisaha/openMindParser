<?php
namespace OpenMindParser\Tests\Models;
use PHPUnit\Framework\TestCase;
use OpenMindParser\Parser;
use \DOMDocument;
class DocumentTest extends TestCase
{
	protected $filePath;
	protected $document;
	
	public function setUp() {
		$this->filePath = __DIR__.'/../TestFile/test_sample.mm';
		$this->document = Parser::getInstance()->buildDocumentTreeFromFilePath($this->filePath);
	}
	
	public function testConstruct() {
		$this->assertAttributeInternalType('string', 'path', $this->document);
		$this->assertAttributeInternalType('string', 'name', $this->document);
		$this->assertAttributeInternalType('int', 'size', $this->document);
		$this->assertAttributeInternalType('object', 'domDocument', $this->document);
		$this->assertInstanceOf('\DOMDocument', $this->document->getDomDocument());
		$this->assertAttributeInternalType('object', 'rootNode', $this->document);
		$this->assertInstanceOf('OpenMindParser\Models\Node', $this->document->getRootNode());
	}
	
	public function testToArray() {
		$awaitedResult = [
			'path'     => $this->filePath,
			'name'     => basename($this->filePath),
			'size'     => filesize($this->filePath),
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
						'icon'     => IMG_ROOT_DIR.'button_ok.png',
						'children' => [],
					],
				],
			],
		];
		
		$this->assertEquals($awaitedResult, $this->document->toArray());
	}
}