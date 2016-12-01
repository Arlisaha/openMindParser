<?php

namespace OpenMindParser\Tests\Models;

use PHPUnit\Framework\TestCase;
use OpenMindParser\Models\Icon;

class IconTest extends TestCase
{
	public function testConstructNullParam() {
		$icon = new Icon();
		
		$this->assertEquals(null, $icon->getName());
		$this->assertEquals(null, $icon->getFullName());
		$this->assertEquals(null, $icon->getPath());
		$this->assertEquals(null, $icon->getShortUri());
		$this->assertEquals(null, $icon->getSize());
		$this->assertEquals(null, $icon->getExtension());
	}
	public function testConstructBuiltinIcon() {
		$icon = new Icon('button_ok');
		
		$this->assertAttributeInternalType('string', 'name', $icon);
		$this->assertEquals('button_ok', $icon->getName());
		$this->assertAttributeInternalType('string', 'extension', $icon);
		$this->assertEquals('png', $icon->getExtension());
		$this->assertAttributeInternalType('string', 'fullName', $icon);
		$this->assertEquals('button_ok.png', $icon->getFullName());
		$this->assertAttributeInternalType('string', 'path', $icon);
		$this->assertEquals(realpath(__DIR__.'/../../img/'.$icon->getFullName()), $icon->getPath());
		$this->assertAttributeInternalType('int', 'size', $icon);
		$this->assertEquals(filesize($icon->getPath()), $icon->getSize());
	}
}