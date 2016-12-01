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
		$this->assertAttributeInternalType('string', 'created', $this->node);
		$this->assertAttributeInternalType('string', 'modified', $this->node);
		$this->assertAttributeInternalType('string', 'position', $this->node);
		$this->assertAttributeInternalType('string', 'vshift', $this->node);
		$this->assertAttributeInternalType('string', 'folded', $this->node);
		$this->assertAttributeInternalType('string', 'text', $this->node);
		$this->assertAttributeInternalType('string', 'fontName', $this->node);
		$this->assertAttributeInternalType('string', 'fontSize', $this->node);
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
		];
		
		$this->assertEquals($awaitedResult, $this->node->toArray());
	}
}