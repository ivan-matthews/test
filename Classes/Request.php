<?php

	namespace Classes;

	class Request
	{
		protected $request_method;
		protected $request_uri;
		protected $headers = array();

		public function __construct($request_method, $request_uri)
		{
			$this->setRequestMethod($request_method);
			$this->setRequestUri($request_uri);
		}

		public function setRequestMethod($request_method)
		{
			$this->request_method = strtoupper($request_method);
			return $this;
		}

		public function getRequestMethod()
		{
			return $this->request_method;
		}

		public function setRequestUri($request_uri)
		{
			$this->request_uri = parse_url($request_uri)['path'];
			return $this;
		}

		public function getRequestUri()
		{
			return $this->request_uri;
		}

		public function setHeadersArray(array $headers)
		{
			foreach ($headers as $key => $header) {
				$this->setHeader($key, $header);
			}
			return $this;
		}

		public function setHeader($key, $header)
		{
			$this->headers[$key] = trim($header);
			return $this;
		}

		public function getHeader($key)
		{
			if (isset($this->headers[$key])) {
				return $this->headers[$key];
			}
			return null;
		}
	}