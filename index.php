<?php

define( 'BASEPATH', dirname(__FILE__));
define( 'VIEWPATH', dirname(__FILE__) . '/App/Views');

require 'vendor/autoload.php';


use League\Container\Container;
use App\Controllers\UsersController;
use Zend\Diactoros\Response;

$container = new Container();

$container->share('UsersController', UsersController::class);
$container->share('response', Response::class);
$container->share('request', function (){
   return \Zend\Diactoros\ServerRequestFactory::fromGlobals(
       $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
   );
});

$container->share('emitter', \Zend\Diactoros\Response\SapiEmitter::class);

$route = new \League\Route\RouteCollection($container);

$route->map('GET', '/', [$container->get('UsersController'), 'create']);

$response = $route->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
