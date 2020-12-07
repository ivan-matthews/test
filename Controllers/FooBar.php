<?php

	namespace Controllers;

	use Classes\Numbers;
	use Classes\Request;
	use Classes\Response;

	class FooBar extends Numbers
	{
		protected $response;
		protected $request;

		public function __construct(Request $request, Response $response){
			$this->request = $request;
			$this->response = $response;
		}

		public function item($number){
			settype($number, 'integer');
			$this->response->set('request', $number);
			$this->response->set('result', $this->getNumber($number));
			return $this;
		}
	}