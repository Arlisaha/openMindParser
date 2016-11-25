<?php

namespace openMindParser\Converters\Model;

use openMindParser\Patterns\AbstractSingleton;
use openMindParser\Objects\Document;
use openMindParser\Parser;
use \InvalidArgumentException;

/*Abstract singleton to help write converters.*/
abstract class AbstractConverter extends AbstractSingleton implements ConverterInterface
{
	/**
	 * The method of the interface ConverterInterface. If the given data is a string and therefore a file path, A Document instance is created. 
	 * In the end, the Document instance is converted.
	 * 
	 * @param mixed $data : The data to convert. Here : a string as the file path or the Document instance.
	 * @param array $options = [] : An array of options for the conversion.
	 * 
	 * @return mixed : The result of the conversion.
	 */
	public function convert($data, $options = []) {
		if(!is_string($data) && !($data instanceof Document)) {
			throw new InvalidArgumentException('The $data variable must be of type "string" (the file path), or an instance of "Document".');
		}
		elseif(!is_array($options)) {
			throw new InvalidArgumentException('The $options variable must be and array.');
		}
		
		if(is_string($data)) {
			$parser = Parser::getInstance();
			$data = $parser->buildDocumentTreeFromFilePath($data);	
		}
		
		return $this->convertFromDocumentInstance($data, $options);
	}
	
	/**
	 * Abstract class to actually perform the conversion from the Document instance passed in parameter.
	 * 
	 * @param mixed $data : The data to convert. Here : a string as the file path or the Document instance.
	 * @param array $options : An array of options for the conversion.
	 * 
	 * @return mixed : The result of the conversion.
	 */
	abstract protected function convertFromDocumentInstance(Document $document, array $options);
}