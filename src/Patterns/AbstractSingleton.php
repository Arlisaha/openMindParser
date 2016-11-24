<?php

namespace openMindParser\Patterns;

abstract class AbstractSingleton
{
	private static $instance = [];
	
	public static function getInstance() {
		$class = get_called_class();
		
		if (!isset(self::$instance[$class])) {
			self::$instance[$class] = new $class;
		}
		
		return self::$instance[$class];
	}
	
	protected function __construct(){}
	protected function __clone(){}
	protected function __wakeup(){}
}