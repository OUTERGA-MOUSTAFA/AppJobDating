<?php
/*********************/
//  Dynamic Routes

/********************/
namespace App\app\Core;

use App\app\config\config;
use App\app\core\BaseController;

class Router {

    private $Routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

     /********************Exemple**********************/
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

    private function addRoute( string $route,string $method, array|callable $action, array $middleware = [])
    {
        $this->Routes[$method][$route] = ['action' =>$action, 'middleware' => $middleware];
         /**************************Exemple****************************/
        //$action = [ 'App\app\Controllers\UserController','show'];
        //Ex: $action = [UserController::class, 'show'];
    }


    public function get(string $route, array|callable $action, array $middleware = [])
    {
        $this->addRoute(trim($route, '/'), 'GET', $action, $middleware);
    }


    public function post(string $route, array|callable $action, array $middleware = [])
    {
        $this->addRoute(trim($route, '/'), 'POST', $action, $middleware );
    }


    public function put(string $route, array|callable $action, array $middleware = [])
    {
        $this->addRoute( trim($route, '/'), 'PUT', $action, $middleware );
    }



    public function delete(string $route, array|callable $action, array $middleware = [])
    {
        $this->addRoute(trim($route, '/'), 'DELETE', $action, $middleware);
    }


    // $router->dispatch();
    public function dispatch()
    {
        // Get the requested route and clean it
        $requestedRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // إزالة المائل (/) من البداية والنهاية
        $requestedRoute = trim($requestedRoute, '/') ?: '/';

        $routes = $this->Routes[$_SERVER['REQUEST_METHOD']];
    
        foreach ($routes as $route => $routeData)
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
            
                // middleware
                foreach ($routeData['middleware'] as $middleware) {
                    (new $middleware)->handle();
                }
                
                // Get all user requested path params values after removing the first matches.
                array_shift($matches);
                $routeParamsValues = $matches;

                // Find all route params names from route and save in $routeParamsNames
                $routeParamsNames = [];
                //preg_match_all كيجبد أسماء variables
                if (preg_match_all('/{(\w+)(:[^}]+)?}/', $route, $matches))
                {// $matches = [
                //      0 => ['{postId}', '{commentId}'],
                //      1 => ['postId', 'commentId']
                //  ];
                    $routeParamsNames = $matches[1];
                    // $routeParamsValues = [10, 3];
                    // $routeParamsNames  = ['postId', 'commentId'];
                }
                 /********************Exemple**********************/
                //$routeParams = [
                    // 'postId' => 10,
                    // 'commentId' => 3
                    // ];
                // Combine between route parameter names and user provided parameter values.
                $routeParams = !empty($routeParamsNames) ? array_combine($routeParamsNames, $routeParamsValues) : [];
                // $routeParams = array_combine($routeParamsNames, $routeParamsValues);
                
                return $this->resolveAction($routeData['action'], $routeParams);
                /********************Exemple**********************/
                // class UserController {
                //     public function show($id) {
                //         echo "عرض ملف المستخدم ذو الرقم: " . $id;
                //     }
            }
        }
        // 4. إذا لم يوجد المسار
        return $this->abort();
    }

     private function resolveAction($action, array $params = [])
    {
        
        // case 1: Closure
        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }

        // case 2: Controller + method
        [$controllerClass, $method] = $action;
        
        // using Reflection func for paramettres be compatible
    $reflectionMethod = new \ReflectionMethod($controllerClass, $method);
    $parameters = $reflectionMethod->getParameters();
    
    $dependencies = []; 

    foreach ($parameters as $parameter) {
        $name = $parameter->getName(); // get var for ex id

        if (array_key_exists($name, $params)) {
            // if name exists in url params, get it here
            $dependencies[] = $params[$name];
        } elseif ($parameter->isDefaultValueAvailable()) {
            // if not exists give him a defaulth value
            $dependencies[] = $parameter->getDefaultValue();
        } else {
            // problem on params or wrong name give him null
            $dependencies[] = null;
        }
    }

        // create a new class and call func
        $controller = new $controllerClass();

        return call_user_func_array([$controller, $method], $params);
    }

    protected function abort()
    {
        // 4. إذا لم يوجد المسار
        http_response_code(404);
        require __DIR__ . '/../views/404.php';
        exit;
    }

    // behind code
    // Route: user/{id}
    // URL:   user/5

    // preg_match_all  → ['id']
    // preg_match      → ['5']

    // array_combine   → ['id' => 5]

    // Controller->show(5)
}
