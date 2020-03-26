<?php
	session_start();

//	header("Access-Control-Allow-Origin: http://talento.carsa.com.py");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

	date_default_timezone_set('America/Asuncion');

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	use \Tuupola\Middleware\HttpBasicAuthentication;

	require __DIR__.'/../vendor/autoload.php';
	$settings = require __DIR__.'/../src/settings.php';

	$app = new \Slim\App($settings);
	require __DIR__.'/../src/dependencies.php';

	$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
		"users" => [
			"th_admin" => "th_admin2020"
		]
	]));

	//ROUTES
	require __DIR__.'/../src/routes.php';
	
	$app->run();