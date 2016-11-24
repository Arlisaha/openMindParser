<?php

namespace openMindParser\Converters\Model;

interface ConverterInterface
{
	public function convert($data, $options = []);
}