<?php
require_once './libs/router/router.php';
require_once './libs/jwt/jwt.middleware.php';

require_once './app/middlewares/guard-api.middleware.php';
require_once './app/controllers/funcion-api.controller.php';
require_once './app/controllers/auth-api.controller.php';

$router = new Router();

$router->addMiddleware(new JWTMiddleware());

$router->addRoute('auth/login', 'GET', 'AuthApiController', 'login');

$router->addRoute('funciones', 'GET', 'FuncionApiController', 'getFunciones');
$router->addRoute('funciones/:id', 'GET', 'FuncionApiController', 'getFuncion');

$router->addMiddleware(new GuardMiddleware());

$router->addRoute('funciones/:id', 'DELETE', 'FuncionApiController', 'deleteFuncion');
$router->addRoute('funciones', 'POST', 'FuncionApiController', 'insertFuncion');
$router->addRoute('funciones/:id', 'PUT', 'FuncionApiController', 'updateFuncion');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);