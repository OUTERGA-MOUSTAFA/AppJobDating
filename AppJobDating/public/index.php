<?php

namespace App\public;
require_once __DIR__ . '/../vendor/autoload.php';

use App\app\core\Router;

// instatance l router private $routes = [
                                //     'GET' => [],
                                //     'POST' => [],
                                //     'PUT' => [],
                                //     'DELETE' => []
                                // ];
$router = new Router();


$router->get('/dashbord', function(){
     include '..app//views/dashboard.php';
});
// public function get(string $route, array|callable $action)
//     {
//         $this->routes($route, 'GET', $action);
//     }


$router->get("/login",function(){
    include '..app//views/dashboard.php';
});
$router->get("/404",function(){
        include '..app//views/404.php';
});
$router->post("/add",function(){
        print_r($_POST);
});

$router->dispatch();