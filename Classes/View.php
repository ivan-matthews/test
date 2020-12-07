<?php

	namespace Classes;

	class View
	{
		/** @var Request */
		public $request;
		/** @var Response */
		public $response;

		protected $render_type;

		protected $html_content;

		public function __construct(Request $request, Response $response)
		{
			$this->request = $request;
			$this->response = $response;
		}

		public function render($file, array $content){
			ob_start();
			extract($content);
			include $file;
			return ob_get_clean();
		}

		public function renderResponse(){
			$this->setRenderType($this->request->getHeader('Accept'));
			return $this;
		}

		public function renderJSONContent()
		{
			$this->response->header('Content-Type', 'application/json');
			$this->response->sendHeaders();
			print json_encode($this->response->getResponse(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			return exit();
		}

		public function renderHTMLContent(){
			$this->response->header('Content-Type', 'text/html');
			$this->response->sendHeaders();
			$this->renderController();
			$this->renderMainTemplateFile();
			return $this;
		}

		protected function renderMainTemplateFile(){
			include get_file_path("view/index.html.php");
			return $this;
		}

		protected function renderController(){
			$controller_file = get_file_path("view/{$this->response->get('controller')}/{$this->response->get('action')}.html.php");
			if(file_exists($controller_file)){
				return $this->html_content = $this->render($controller_file, $this->response->getResponse());
			}
			return $this->renderErrorPage($this->response->getCode());
		}

		protected function renderErrorPage($error_code){
			$error_file = get_file_path("view/errors/{$error_code}.html.php");
			if(file_exists($error_file)){
				return $this->html_content = $this->render($error_file, array());
			}
			return false;
		}

		protected function setRenderType($accept_type){
			preg_match_all("#([a-z]+)\/([a-z]+)#", $accept_type, $accept_types);
			if(isset($accept_types[2])){
				foreach($accept_types[2] as $accept_type){
					if($this->checkDesiredMethod('render' . $accept_type . 'Content')){
						call_user_func(array($this, 'render' . $accept_type . 'Content'));
						break;
					}
				}
				return $this;
			}
			return $this->renderHTMLContent();
		}

		protected function checkDesiredMethod($method){
			if(method_exists($this, $method)){
				return true;
			}
			return false;
		}
	}