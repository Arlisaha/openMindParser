<?php

namespace openMindParser\Patterns;

/*An abstract class to extend in order to create Singleton. Stores all unique instance in an array, and return it when asked.*/
abstract class AbstractSingleton
{
	/**
	 * @var Array $instances : array with all instances of all singleton class already called.
	 */
	private static $instances = [];
	
	/**
	 * Return the instance of the child class.
	 */
	public static function getInstance() {
		$class = get_called_class();
		
		if (!isset(self::$instances[$class])) {
			self::$instances[$class] = new $class;
		}
		
		return self::$instances[$class];
	}
	
	/*Bunch of protected magic methods that must not be called in a Singleton pattern.*/
	protected function __construct(){}
	protected function __clone(){}
	protected function __wakeup(){}
}