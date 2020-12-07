<?php

	namespace Controllers;

	use Classes\Request;
	use Classes\Response;

	class MainController
	{
		protected $response;
		protected $request;

		public function __construct(Request $request, Response $response)
		{
			$this->request = $request;
			$this->response = $response;
		}

		public function index()
		{
			$this->response->set('controller', 'main');
			$this->response->set('action', 'index');
			return $this;
		}
	}