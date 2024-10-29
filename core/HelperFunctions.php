<?php

use Core\Router;
use Core\Session;

function basepath($path = null)
{
    $basePath = __DIR__ . "/../";
    return $path ? "{$basePath}{$path}" : $basePath;
}

function env($key, $default = null)
{
    static $env = [];
    $envPath = basepath('.env');

    if (empty($env)) {
        if (!file_exists($envPath)) {
            throw new Exception('.env file not found');
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;

            [$envKey, $envValue] = explode('=', $line, 2);
            $env[trim($envKey)] = trim($envValue);
        }
    }

    return $env[$key] ?? $default;
}

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function view($view, $attributes = [])
{
    extract($attributes);
    require basepath("resources/views/$view");
}

function route($name)
{
    $routes = Router::getRoutes();
    return array_values(array_filter($routes, function ($route) use ($name) {
        return $route['name'] === $name;
    }))[0]['url'] ?? null;
}

function error($name)
{
    return Session::getError($name) ?? null;
}

function old($name)
{
    return Session::getOld($name) ?? null;
}

// function parseURI($url)
// {
//     return explode("?", $url)[0];
// }
