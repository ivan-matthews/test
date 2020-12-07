<?php

	use Classes\Router\Router;
	use Classes\Router\Maker;
	use Interfaces\Router\Maker as MakerInterface;

	Router::any('/', function (MakerInterface $route) {
		$route->class(\Controllers\MainController::class);
		$route->action('index');
	});

	Router::get('/foobar/{number}', function (MakerInterface $route) {
		$route->class(\Controllers\FooBar::class);
		$route->action('item');
		$route->mask('([0-9]+)');
	});