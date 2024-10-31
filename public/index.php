<?php

use Core\RedirectResponse;
use Core\Request;
use Core\Router;
use Core\Session;
use Core\Validator;
use Core\ViewResponse;

session_start();
require __DIR__ . '/../bootstrap/app.php';
require basepath('routes/web.php');

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$route = Router::matchWithURL($method, $url);

if (!$route) {
    http_response_code(404);
    echo "404 Not Found";
    die();
}

$action = $route['action'];
$request = new Request($_REQUEST);

$middlewareNames = $route['middleware'];

if ($middlewareNames) {
    $middlewares = require basepath('app/Http/Kernel.php');
    foreach ($middlewareNames as $middlewareName) {
        $middleware = new $middlewares[$middlewareName];
        if (!method_exists($middleware, 'handle')) die();
        $middleware->handle($request);
    }
}

if (is_array($action)) {
    [$controller, $method] = $action;

    if (!class_exists($controller)) {
        dd("class does not exist");
    }

    if (!method_exists(new $controller, $method)) {
        dd("method does not exist");
    }

    $reflection = new ReflectionMethod($controller, $method);
    $params = $reflection->getParameters();

    $dependencies = [];
    foreach ($params as $param) {
        $type = $param->getType();
        if ($type) {
            if ($type instanceof ReflectionNamedType) {
                $className = $type->getName();
                if (is_subclass_of($className, Request::class) || $className === "Core\Request") {
                    $requestClass = new $className($_REQUEST);
                    if (method_exists($requestClass, 'rules')) {
                        $rules = $requestClass->rules();
                        $validator = Validator::make($_REQUEST, $rules);
                        if (!$validator) {
                            Session::addOlds($_REQUEST);
                            header('location: ' . $_SERVER['HTTP_REFERER']);
                        }
                    }
                    $dependencies[] = $requestClass;
                }
            } else {
                dd('Parameter: ' . $param->getName() . ' Type: ' . $type . PHP_EOL);
            }
        }
    }
    $response = call_user_func([new $controller, $method], ...$dependencies);
} else {
    $response = call_user_func($action, $request);
}

if ($response instanceof RedirectResponse) {
    $response->redirect();
}

if ($response instanceof ViewResponse) {
    $response->view();
}


Session::unflash();
