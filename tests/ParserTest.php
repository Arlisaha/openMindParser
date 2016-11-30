<?php

namespace OpenMindParser\Tests;

use PHPUnit\Framework\TestCase;
use OpenMindParser\Parser;
use OpenMindParser\Models\Document;
use OpenMindParser\Models\Node;
use OpenMindParser\Models\NodeList;
use OpenMindParser\Models\Icon;
use \DOMDocument;

class ParserTest extends TestCase
{
	protected $parser;
	protected $wrongFilePath;
	protected $rightFilePath;
	protected $node02 = '		<node COLOR="#020202" CREATED="0000000000000" FOLDED="true" ID="0_2" MODIFIED="0000000000000" POSITION="right" TEXT="node_0_2" VSHIFT="-45">
			<icon BUILTIN="button_ok"/>
			<font NAME="SansSerif" SIZE="16"/>
		</node>';
	protected $node011 = '<node COLOR="#011011" CREATED="0000000000000" ID="0_1_1" MODIFIED="0000000000000" TEXT="node_0_1_1">
			</node>';
	protected $node01 = '		<node COLOR="#010101" CREATED="0000000000000" FOLDED="true" ID="0_1" MODIFIED="0000000000000" POSITION="right" TEXT="node_0_1" VSHIFT="-45">
			<font NAME="SansSerif" SIZE="18"/>
			<node COLOR="#011011" CREATED="0000000000000" ID="0_1_1" MODIFIED="0000000000000" TEXT="node_0_1_1">
			</node>
		</node>';
	protected $node0 = '	<node COLOR="#000000" CREATED="0000000000000" ID="0" MODIFIED="0000000000000" TEXT="node_0">
		<font NAME="SansSerif" SIZE="20"/>
		<hook NAME="accessories/plugins/AutomaticLayout.properties"/>
		<node COLOR="#010101" CREATED="0000000000000" FOLDED="true" ID="0_1" MODIFIED="0000000000000" POSITION="right" TEXT="node_0_1" VSHIFT="-45">
			<font NAME="SansSerif" SIZE="18"/>
			<node COLOR="#011011" CREATED="0000000000000" ID="0_1_1" MODIFIED="0000000000000" TEXT="node_0_1_1">
			</node>
		</node>
		<node COLOR="#020202" CREATED="0000000000000" FOLDED="true" ID="0_2" MODIFIED="0000000000000" POSITION="right" TEXT="node_0_2" VSHIFT="-45">
			<icon BUILTIN="button_ok"/>
			<font NAME="SansSerif" SIZE="16"/>
		</node>
	</node>';
	
	public function setUp() {
		$this->parser = new Parser();
		$this->wrongFilePath = '/error/wrong_file.mm';
		$this->rightFilePath = __DIR__.'/TestFile/test_sample.mm';
	}
	
	public function testBuildDocumentTreeFromFilePathWrongFilePath() {
		$this->expectException(\InvalidArgumentException::class);
		
		$this->parser->buildDocumentTreeFromFilePath($this->wrongFilePath);
	}
	
	public function testBuildDocumentTreeFromFilePathRightFilePath() {
		$domDocument = new DOMDocument();
		
		$domDocument->loadXML($this->node02);
		$node02 = new Node($domDocument->documentElement, new NodeList(), new Icon('button_ok'), '0_2', '#020202', '0000000000000', '0000000000000', 'right', '-45', 'true', 'node_0_2', 'SansSerif', '16');
		
		$domDocument->loadXML($this->node011);
		$node011 = new Node($domDocument->documentElement, null, null, '0_1_1', '#011011', '0000000000000', '0000000000000', null, null, null, 'node_0_1_1', null, null);
				
		$domDocument->loadXML($this->node01);
		$node01 = new Node($domDocument->documentElement, new NodeLIst([$node011]), null, '0_1', '#010101', '0000000000000', '0000000000000', 'right', '-45', 'true', 'node_0_1', 'SansSerif', '18');
				
		$domDocument->loadXML($this->node0);
		$node0 = new Node($domDocument->documentElement, new NodeLIst([$node01, $node02]), null, '0', '#000000', '0000000000000', '0000000000000', null, null, null, 'node_0', 'SansSerif', '20');
		
		$domDocument->load($this->rightFilePath);
		$awaitedDocument = new Document($domDocument, $node0, $this->rightFilePath, 'test_sample.mm', filesize($this->rightFilePath));
		
		$document = $this->parser->buildDocumentTreeFromFilePath($this->rightFilePath);
		
		$this->assertEquals($awaitedDocument, $document);
	}
}