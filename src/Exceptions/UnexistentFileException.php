<?php

namespace OpenMindParser\Exceptions;

use \Exception;

/*Custom Exception class thrown when a file does not exist in the file system.*/
class UnexistentFileException extends Exception
{
	public function __construct($message, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}