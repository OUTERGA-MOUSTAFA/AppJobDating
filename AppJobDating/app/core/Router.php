<?php

namespace App\app\Core;
require_once __DIR__ . '/../vendor/autoload.php';
use App\app\core\config;

class Router {

    private $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    private function addRoute(string $method, string $route, array|callable $action)
    {
        $this->routes[$method][$route] = $action;
    }


    public function get(string $route, array|callable $action)
    {
        $this->addRoute(trim($route, '/'), 'GET', $action);
    }


    public function post(string $route, array|callable $action)
    {
        $this->addRoute(trim($route, '/'), 'POST', $action);
    }


    public function put(string $route, array|callable $action)
    {
        $this->addRoute( trim($route, '/'), 'PUT', $action);
    }



    public function delete(string $route, array|callable $action)
    {
        $this->addRoute(trim($route, '/'), 'DELETE', $action);
    }


    // $router->dispatch();
    public function dispatch()
    {
        // Get the requested route.
        $requestedRoute = trim($_SERVER['REQUEST_URI'], '/') ?? '/';
         if (BASE_PATH !== '' && defined('BASSE_PATH')) {
            $requestedRoute = str_replace(BASE_PATH, '', $requestedRoute);
        }
        $requestedRoute = str_replace(BASE_PATH, '', $requestedRoute);
        $routes = self::$routes[$_SERVER['REQUEST_METHOD']];

        foreach ($routes as $route => $action)
        {
            // Transform route to regex pattern.
            $routeRegex = preg_replace_callback('/{\w+(:([^}]+))?}/', function ($matches)
            {
                return isset($matches[1]) ? '(' . $matches[2] . ')' : '([a-zA-Z0-9_-]+)';
            }, $route);

            // Add the start and end delimiters.
            $routeRegex = '@^' . $routeRegex . '$@';

            // Check if the requested route matches the current route pattern.
            if (preg_match($routeRegex, $requestedRoute, $matches))
            {
                // Get all user requested path params values after removing the first matches.
                array_shift($matches);
                $routeParamsValues = $matches;

                // Find all route params names from route and save in $routeParamsNames
                $routeParamsNames = [];
                if (preg_match_all('/{(\w+)(:[^}]+)?}/', $route, $matches))
                {
                    $routeParamsNames = $matches[1];
                }

                // Combine between route parameter names and user provided parameter values.
                $routeParams = array_combine($routeParamsNames, $routeParamsValues);

                return  $this->resolveAction($action, $routeParams);
            }
        }
        return $this->abort();
    }

    function resolveAction($action , $paramsRoute= []){
        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }

        [$controller, $method] = $action;
        $controller = new $controller;

        return call_user_func_array([$controller, $method], $params);
    }

    protected function abort()
    {
        http_response_code(404);
        echo "404 | Page Not Found";
        exit;
    }
}
