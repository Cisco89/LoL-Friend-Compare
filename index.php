<?php

use App\Controllers\SummonersController;
use League\Container\Container;
use App\Controllers\UsersController;
use Zend\Diactoros\Response;
use Illuminate\Database\Capsule\Manager as Capsule;

define( 'BASEPATH', dirname(__FILE__));
define( 'VIEWPATH', dirname(__FILE__) . '/App/Views');

require 'vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv("DATABASE_HOST"),
    'database'  => getenv("DATABASE_NAME"),
    'username'  => getenv("DATABASE_USER"),
    'password'  => getenv("DATABASE_PASSWORD"),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);

$capsule->bootEloquent();

$container = new Container();

$container->share('UsersController', UsersController::class);
$container->share('SummonersController', SummonersController::class);
$container->share('response', Response::class);
$container->share('request', function (){
   return \Zend\Diactoros\ServerRequestFactory::fromGlobals(
       $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
   );
});

$container->share('emitter', \Zend\Diactoros\Response\SapiEmitter::class);

$route = new \League\Route\RouteCollection($container);

$route->map('GET', '/', [$container->get('UsersController'), 'create']);
$route->map('POST', '/users/registration', [$container->get('UsersController'), 'store']);
$route->map('GET', '/users/login', [$container->get('UsersController'), 'login'])->middleware(function (){
    if(!isset($_SESSION['user']['id'])){
        return;
    }
    header('Location: http://lol-friend-compare.local/users/dashboard');
    exit();
});
$route->map('POST', '/users/login', [$container->get('UsersController'), 'validate']);
$route->map('GET', '/users/dashboard', [$container->get('UsersController'), 'dashboard']);
$route->map('GET', '/users/logout', [$container->get('UsersController'), 'logout']);
$route->map('GET', '/summoners/add', [$container->get('SummonersController'), 'create']);
$route->map('POST', '/summoners/add', [$container->get('SummonersController'), 'store']);
$route->map('GET', '/summoners/{id}/remove', [$container->get('SummonersController'), 'destroy']);

$response = $route->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
