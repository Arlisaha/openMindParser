<?php

namespace openMindParser\Patterns;

abstract class AbstractSingleton
{
	protected static $instance;
	
	public static function getInstance() {
		if(self::$instance == null) {
            $class = get_called_class();
            self::$instance = new $class;
        }
        return self::$instance;
	}
	
	protected function __construct(){}
	protected function __clone(){}
	protected function __wakeup(){}
}