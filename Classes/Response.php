<?php

	namespace Classes;

	class Response
	{
		protected $code = 200;

		protected $headers = array();

		protected $statuses = array(
			200 => "200 OK",
			400 => "400 Bad Request",
			401 => "401 Unauthorized",
			403 => "403 Forbidden",
			404 => "404 Not Found",
			405 => "405 Method Not Allowed",
			500 => "500 Internal Server Error",
		);

		protected $response = array(
			'request'	=> null,
			'result'	=> null,
			'datetime'	=> null
		);

		public function __construct(){
			$this->response['datetime'] = date('Y-m-d H:i:s');
		}

		public function header($key, $value){
			$this->headers[$key] = $value;
			return $this;
		}

		public function code($code){
			$this->code = $code;
			return $this;
		}

		public function get($key){
			if(isset($this->response[$key])){
				return $this->response[$key];
			}
			return null;
		}

		public function set($key, $value){
			$this->response[$key] = $value;
			return $this;
		}

		public function getResponse(){
			return $this->response;
		}

		public function sendHeaders(){
			foreach($this->headers as $header_key => $header_value){
				header("{$header_key}: {$header_value}", true, $this->code);
			}
			http_response_code($this->code);
			header("Status: {$this->statuses[$this->code]}");
			return $this;
		}
	}