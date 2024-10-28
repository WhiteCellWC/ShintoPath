<?php

use Core\Router;

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
if (is_array($action)) {
    [$controller, $method] = $action;
    call_user_func([new $controller, $method]);
} else {
    call_user_func($action);
}
