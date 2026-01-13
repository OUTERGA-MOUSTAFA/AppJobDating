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


    public function get(string $route, array|callable $action)
    {
        $this->routes($route, 'GET', $action);
    }


    public function post(string $route, array|callable $action)
    {
        $this->routes($route, 'POST', $action);
    }


    public function put(string $route, array|callable $action)
    {
        $this->routes($route, 'PUT', $action);
    }



    public function delete(string $route, array|callable $action)
    {
        $this->routes($route, 'DELETE', $action);
    }


    // $router->dispatch();
    public function dispatch()
    {
        // Get the requested route.
        $requestedRoute = trim($_SERVER['REQUEST_URI'], '/') ?? '/';
        define('BASE_PATH', '/AppJobDating');
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
        return $this->abort('404 Page not found');
    }


}

