<?php

	namespace Interfaces\Router;

	interface Maker
	{
		public function class($value);

		public function action($value);

		public function pattern($value);

		public function mask($value);

		public function modifier($value);

		public function method($value);
	}