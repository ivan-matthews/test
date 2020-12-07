<?php

	namespace Classes\Router;

	use Classes\Request;
	use Classes\Response;

	/**
	 * Class Router
	 * @package Classes\Router
	 * @method static get($pattern, callable $callback)
	 * @method static post($pattern, callable $callback)
	 * @method static put($pattern, callable $callback)
	 * @method static delete($pattern, callable $callback)
	 * @method static patch($pattern, callable $callback)
	 * @method static options($pattern, callable $callback)
	 * @method static head($pattern, callable $callback)
	 * @method static connect($pattern, callable $callback)
	 * @method static trace($pattern, callable $callback)
	 * @method static any($pattern, callable $callback)
	 */
	class Router
	{
		private static $routes = array();

		/** @var Request */
		protected $request;
		/** @var Response */
		protected $response;

		protected $request_method;
		protected $request_uri;

		protected $controller = array();

		public static function __callStatic($name, $arguments)
		{
			return self::registerRoute($name, $arguments[0], $arguments[1]);
		}

		public static function registerRoute($method, $pattern, callable $callback_function){
			$routes_maker = new Maker($method, $pattern);
			call_user_func($callback_function, $routes_maker);
			return self::addRoute($routes_maker->getRoute());
		}

		public static function addRoute(array $route){
			self::$routes[] = $route;
			return true;
		}

		public function getRoutes(){
			return self::$routes;
		}

		public function __construct(Request $request, Response $response){
			$this->request = $request;
			$this->response = $response;
			$this->request_method = $this->request->getRequestMethod();
			$this->request_uri = $this->request->getRequestUri();
		}

		public function parseCurrentUrl(){
			foreach(self::$routes as $route){
				if($this->parseLink($route)){
					break;
				}
			}
			return $this->launchController();
		}

		protected function parseLink($route){
			if($route['method'] === 'ANY'){
				return $this->searchLink($route);
			}
			return $this->parseFixedMethod($route);
		}

		protected function parseFixedMethod($route){
			if($route['method'] === $this->request_method){
				return $this->searchLink($route);
			}
			return false;
		}

		protected function preparePattern($pattern, $mask){
			return preg_replace("#\{(.*?)\}#",$mask, $pattern);
		}

		protected function searchLink($route){
			$pattern = $this->preparePattern($route['pattern'], $route['mask']);
			preg_match("#{$pattern}#{$route['modifier']}", $this->request_uri, $params);
			if(isset($params[0]) && $params[0] === $this->request_uri){
				$this->controller['class'] = $route['class'];
				$this->controller['action'] = $route['action'];
				$this->controller['params'] = array_slice($params,1);
				return true;
			}
			return false;
		}

		protected function launchController(){
			if($this->controller){
				$this->response->code(200);
				if($this->runController($this->controller['class'], $this->controller['action'],...$this->controller['params'])){
					return true;
				}
			}
			$this->response->code(404);
			return false;
		}

		protected function runController($class, $action, ...$params){
			$object = new $class($this->request, $this->response);
			return call_user_func_array(array($object, $action), $params);
		}
	}