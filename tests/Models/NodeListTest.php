<?php
namespace OpenMindParser\Tests\Models;

use \PHPUnit_Framework_TestCase as TestCase;
use OpenMindParser\Models\NodeList;
use OpenMindParser\Models\Node;

class NodeListTest extends TestCase
{
	public function testConstructNullParam() {
		$nodeList = new NodeList();
		
		$this->assertAttributeInternalType('array', 'list', $nodeList);
		$this->assertCount(0, $nodeList->getIterator());
	}
	
	public function testConstructWrongArrayValue() {
		$this->expectException('PHPUnit_Framework_Error_Warning');
		
		$nodeList = new NodeList(['error']);
	}
	
	public function testConstructGoodArrayValue() {
		$nodeList = new NodeList([new Node()]);
		
		$this->assertAttributeInternalType('array', 'list', $nodeList);
		$this->assertCount(1, $nodeList->getIterator());
	}
	
	public function testAdd() {
		$nodeList = new NodeList([new Node()]);
		$nodeList->add(new Node());
		
		$this->assertAttributeInternalType('array', 'list', $nodeList);
		$this->assertCount(2, $nodeList->getIterator());
	}
}