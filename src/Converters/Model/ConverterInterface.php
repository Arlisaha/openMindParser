<?php

namespace openMindParser\Converters\Model;

/*Interface for converters*/
interface ConverterInterface
{
	/*Meant to be the only public function to convert the given $data, with optional array $options.*/
	public function convert($data, $options = []);
}