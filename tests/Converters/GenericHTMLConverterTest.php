<?php

namespace openMindParser\Tests\Converters;

use \PHPUnit_Framework_TestCase as TestCase;
use OpenMindParser\Converters\HTML\GenericHTMLConverter;

class GenericHTMLConverterTest extends TestCase
{
	public function testConvert() {
		$filePath = __DIR__.'/../TestFile/test_sample.mm';
		$awaitedHtml = '<ul><li style="color:#000000;font-family:SansSerif;font-size:20;" id="0">node_0<ul><li style="color:#010101;font-family:SansSerif;font-size:18;" id="0_1">node_0_1<ul><li style="color:#011011;" id="0_1_1">node_0_1_1</li></ul></li></ul><ul><li style="color:#020202;font-family:SansSerif;font-size:16;" id="0_2"><img src="/openMindParser/img/button_ok.png" alt="button_ok">node_0_2</li></ul></li></ul>';
		
		$htmlConverter = new GenericHTMLConverter();
		
		$htmlStr = $htmlConverter->convert($filePath, [
			GenericHTMLConverter::MAIN_TAG_KEY => [
				[GenericHTMLConverter::TAG_KEY => 'ul', GenericHTMLConverter::ATTRIBUTES_KEY =>[]], 
				[GenericHTMLConverter::TAG_KEY => 'li', GenericHTMLConverter::ATTRIBUTES_KEY =>[]],
			], 
			GenericHTMLConverter::MAIN_ICON_KEY => [
				GenericHTMLConverter::DISPLAY_ICON_KEY => true,
				GenericHTMLConverter::PATH_ICON_KEY    => [
					GenericHTMLConverter::CALLBACK_PATH_ICON_KEY => function($fullName, $options = null){return '/openMindParser/img/'.$fullName;},
				],
			],
		]);
		
		$this->assertEquals(trim($awaitedHtml), trim($htmlStr->saveHTML()));
	}
}