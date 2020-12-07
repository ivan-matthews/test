<?php

	namespace Classes;

	class View
	{
		/** @var Request */
		protected $request;
		/** @var Response */
		protected $response;

		protected $render_type;

		public function __construct(Request $request, Response $response)
		{
			$this->request = $request;
			$this->response = $response;
		}

		public function renderJSONContent()
		{
			$this->response->header('Content-Type', 'application/json');
			$this->response->sendHeaders();
			print json_encode($this->response->getResponse(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			return exit();
		}
	}