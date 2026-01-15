<?php

namespace App\app\Core;

use App\app\core\config;

class Router {

    private $Routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];
// $Routes = [
//     'GET' => ['' => function() { echo "Home"; }, 'dashboard' => [HomeController::class, 'index'], 'users' => [UserController::class, 'list'], 'user/{id}' => [UserController::class, 'show']
//     ],
//     'POST' => [
//         'login' => [AuthController::class, 'login'],
//         'register' => [AuthController::class, 'register']
//     ],
//     'PUT' => [],
//     'DELETE' => []
// ];

    private function addRoute( string $route,string $method, array|callable $action)
    {
        $this->Routes[$method][$route] = $action;
        //$action = [ 'App\app\Controllers\UserController','show'];
        //Ex: $action = [UserController::class, 'show'];
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
        //  if (BASE_PATH !== '' && defined('BASE_PATH',"/AppJobDating")) {
        //     $requestedRoute = str_replace(BASE_PATH, '', $requestedRoute);
        // }
        // $requestedRoute = str_replace(BASE_PATH, '', $requestedRoute);
        
        $routes = $this->Routes[$_SERVER['REQUEST_METHOD']];

        foreach ($routes as $route => $action)
        {
            // Transform route to regex pattern.
            $routeRegex = preg_replace_callback('/{\w+(:([^}]+))?}/', function ($matches)//  $matches=> id = 5
            {//       $route = 'user/{id}'; قلب على
                return isset($matches[1]) ? '(' . $matches[2] . ')' : '([a-zA-Z0-9_-]+)';
                
            }, $route);

            // Add the start and end delimiters.
            $routeRegex = '@^' . $routeRegex . '$@';

            // Check if the requested route matches the current route pattern.
            if (preg_match($routeRegex, $requestedRoute, $matches))
            {// يحول route لـ regex
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
            return call_user_func_array($action, $paramsRoute);
        }

        [$controller, $method] = $action;
        // $action = [UserController::class, 'show'];
        // $controller = "UserController";
        // $method = "show";

        $controller = new $controller;
        //$controller = new UserController();

        return call_user_func_array([$controller, $method], $paramsRoute);
        //$controller->show(5);
    }

    protected function abort()
    {
        http_response_code(404);
        include BASE_PATH . '/app/views/404.php';
        exit();
    }
}
