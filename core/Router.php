<?php

namespace Core;

use function PHPSTORM_META\type;

class Router
{
    protected static array $routes;
    protected static array $groupAttributes = [];

    public static function get(string $url, callable | array $action)
    {
        static::insertRoute($url, $action, 'GET');
        return new static;
    }

    public static function post(string $url, callable | array $action)
    {
        static::insertRoute($url, $action, 'POST');
        return new static;
    }

    public static function insertRoute(string $url, callable | array $action, string $method)
    {
        $route = [
            'url' => $url,
            'action' => $action,
            'middleware' => [],
            'method' => $method
        ];

        if (!empty(static::$groupAttributes)) {
            $route = array_merge($route, static::$groupAttributes);
        }

        static::$routes[] = $route;
    }

    public static function getRoutes()
    {
        return static::$routes;
    }

    public static function matchWithURL(string $method, string $url): callable|array|null
    {
        return array_values(array_filter(static::$routes, function ($route) use ($method, $url) {
            return $route['method'] === $method && $route['url'] === $url;
        }))[0] ?? null;
    }

    public static function matchWithName($name)
    {
        return array_values(array_filter(static::$routes, function ($route) use ($name) {
            return $route['name'] === $name;
        }))[0] ?? null;
    }

    public static function middleware(string | array $middlewares)
    {
        $lastIndex = array_key_last(static::$routes);
        if (gettype($middlewares) === "string") {
            $middlewares = explode("|", $middlewares);
        }
        static::$routes[$lastIndex] = [...static::$routes[$lastIndex], 'middleware' => $middlewares];
        return new static;
    }

    public static function name(string $name)
    {
        $lastIndex = array_key_last(static::$routes);
        static::$routes[$lastIndex] = [...static::$routes[$lastIndex], 'name' => $name];
        return new static;
    }

    public static function group(array $attributes, callable $callback)
    {
        static::$groupAttributes = $attributes;

        $callback();

        static::$groupAttributes = [];
    }
}
