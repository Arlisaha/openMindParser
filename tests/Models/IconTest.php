<?php

namespace OpenMindParser\Tests\Models;

use PHPUnit\Framework\TestCase;
use OpenMindParser\Models\Icon;

class IconTest extends TestCase
{
	public function testConstructNullParam() {
		$icon = new Icon();
		
		$this->assertEquals(null, $icon->getName());
		$this->assertEquals(null, $icon->getFilePath());
		$this->assertEquals(null, $icon->getSize());
		$this->assertEquals(null, $icon->getExtension());
	}
	public function testConstructBuiltinIcon() {
		$icon = new Icon('button_ok');
		
		$this->assertAttributeInternalType('string', 'name', $icon);
		$this->assertEquals('button_ok', $icon->getName());
		$this->assertAttributeInternalType('string', 'filePath', $icon);
		$this->assertEquals(realpath(__DIR__.'/../../img/'.$icon->getName().'.'.$icon->getExtension()), $icon->getFilePath());
		$this->assertAttributeInternalType('int', 'size', $icon);
		$this->assertEquals(filesize($icon->getFilePath()), $icon->getSize());
		$this->assertAttributeInternalType('string', 'extension', $icon);
		$this->assertEquals('png', $icon->getExtension());
	}
}