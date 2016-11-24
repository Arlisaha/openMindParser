<?php

namespace openMindParser\Converters\Model;

interface ConverterInterface
{
	public static function convert($data, $options = []);
}