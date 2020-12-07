<?php

	use Classes\Request;
	use Classes\Router\Router;
	use Classes\Response;
	use Classes\View;

	$_SERVER['REQUEST_METHOD'] = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
	$_SERVER['REQUEST_URI'] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

	require "hub.php";
	require "router.php";

	$request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
	$request->setHeadersArray(getallheaders());

	$response = new Response();
	$router = new Router($request, $response);

	$router->parseCurrentUrl();

	$template = new View($request, $response);
	$template->renderJSONContent();