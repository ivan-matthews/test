<?php

	namespace Classes\Router;

	use Interfaces\Router\Maker as Router;

	class Maker implements Router
	{
		private $route = array(
			'class'		=> '',
			'action'	=> '',
			'pattern'	=> '',
			'mask'		=> '([a-z0-9]+)',
			'modifier'	=> 'i',
			'method'	=> 'GET',
		);

		public function __construct($method, $pattern){
			$this->method($method);
			$this->pattern($pattern);
		}

		public function class($value){
			$this->route['class'] = $value;
			return $this;
		}

		public function action($value){
			$this->route['action'] = $value;
			return $this;
		}

		public function pattern($value){
			$this->route['pattern'] = $value;
			return $this;
		}

		public function mask($value){
			$this->route['mask'] = $value;
			return $this;
		}

		public function modifier($value){
			$this->route['modifier'] = $value;
			return $this;
		}

		public function method($value){
			$this->route['method'] = strtoupper($value);
			return $this;
		}

		public function getRoute(){
			return $this->route;
		}
	}