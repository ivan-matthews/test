<?php

	define('ROOT', __DIR__);

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	spl_autoload_register('classes_autoloader');

	function classes_autoloader($class_name)
	{
		$class_path = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
		$class_file = get_file_path($class_path . '.php');
		if (file_exists($class_file)) {
			include_once $class_file;
			return true;
		}
		return false;
	}

	function get_file_path($file_name)
	{
		$file_name = ltrim($file_name, '/');
		return ROOT . '/' . $file_name;
	}

	function debug(...$data)
	{
		print '<pre>';
		foreach($data as $item){
			print_r($item);
			print  '<hr>';
		}
		print '</pre>';
		die;
	}