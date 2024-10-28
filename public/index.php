<?php

use Core\Request;
use Core\Router;

session_start();
require __DIR__ . '/../bootstrap/app.php';
require basepath('routes/web.php');


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$route = Router::match($method, $url);

if (!$route) {
    http_response_code(404);
    echo "404 Not Found";
    die();
}

$action = $route['action'];
$request = new Request($_REQUEST);
if (is_array($action)) {
    [$controller, $method] = $action;
    call_user_func([new $controller, $method], $request);
} else {
    call_user_func($action, $request);
}

// $action = $route['action'];
// $request = new Request($_REQUEST);
// if (is_array($action)) {
//     [$controller, $method] = $action;
//     $reflection = new ReflectionMethod(AuthController::class, 'login');
//     $params = $reflection->getParameters();

//     $dependencies = [];
//     foreach ($params as $param) {
//         dd($params);
//         $type = $param->getType();
//         if ($type && !$type->isBuiltin()) {
//             $className = $type->getName();
//             $dependencies[] = new $className($_REQUEST);
//         }
//     }
//     call_user_func([new $controller, $method], $request);
// } else {
//     call_user_func($action, $request);
// }