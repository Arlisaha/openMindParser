<?php

namespace OpenMindParser\Tests\Models;

use PHPUnit\Framework\TestCase;
use OpenMindParser\Parser;

class NodeTest extends TestCase
{
	protected $filePath;
	protected $document;
	protected $node;
	
	public function setUp() {
		$this->filePath = __DIR__.'/../TestFile/test_sample.mm';
		$parser = new Parser();
		$this->document = $parser->buildDocumentTreeFromFilePath($this->filePath);
		$this->node = $this->document->getRootNode()->getChildren()->getIterator()[1];
	}
	
	public function testConstruct() {
		$this->assertAttributeInternalType('string', 'id', $this->node);
		$this->assertAttributeInternalType('string', 'color', $this->node);
		$this->assertAttributeInternalType('float', 'created', $this->node);
		$this->assertAttributeInternalType('float', 'modified', $this->node);
		$this->assertAttributeInternalType('string', 'position', $this->node);
		$this->assertAttributeInternalType('int', 'vshift', $this->node);
		$this->assertAttributeInternalType('bool', 'folded', $this->node);
		$this->assertAttributeInternalType('string', 'text', $this->node);
		$this->assertAttributeInternalType('bool', 'bold', $this->node);
		$this->assertAttributeInternalType('bool', 'italic', $this->node);
		$this->assertAttributeInternalType('string', 'fontName', $this->node);
		$this->assertAttributeInternalType('int', 'fontSize', $this->node);
		$this->assertAttributeInternalType('object', 'icon', $this->node);
		$this->assertInstanceOf('OpenMindParser\Models\Icon', $this->node->getIcon());
		$this->assertAttributeInternalType('object', 'children', $this->node);
		$this->assertInstanceOf('OpenMindParser\Models\NodeList', $this->node->getChildren());
		$this->assertAttributeInternalType('object', 'domNode', $this->node);
		$this->assertInstanceOf('\DOMElement', $this->node->getDomNode());
	}
	
	public function testToArray() {
		$awaitedResult = [
			'id'       => '0_2',
			'color'    => '#020202', 
			'created'  => 1477421861749,
			'modified' => 1477421861749,
			'position' => 'right',
			'vshift'   => -45,
			'folded'   => true,
			'text'     => 'node_0_2',
			'bold'     => false,
			'italic'   => false,
			'fontName' => 'SansSerif',
			'fontSize' => 16,
			'icon'     => [
				'name'      => 'button_ok',
				'fullName'  => 'button_ok.png',
				'path'      => realpath(__DIR__.'/../../img/button_ok.png'),
				'shortUri'  => '/img/button_ok.png',
				'size'      => filesize(realpath(__DIR__.'/../../img/button_ok.png')),
				'extension' => 'png',
			],
			'children' => [],
		];
		
		$this->assertEquals($awaitedResult, $this->node->toArray());
	}
}