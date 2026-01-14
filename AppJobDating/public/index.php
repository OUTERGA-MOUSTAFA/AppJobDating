<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\app\core\Router;

define("BASE_PATH", __DIR__ . "/AppJopDating");
// instatance l router private $routes = [ 'GET' => [],'POST' => [],'PUT' => [],'DELETE' => [] ];
$router = new Router();


$router->get('dashbord', function(){
    include_once __DIR__ . '/../app//views/dashboard.php';
});
// public function get(string $route, array|callable $action)
//     {
//         $this->routes($route, 'GET', $action);
//     }

$router->get("login",function(){
   include_once __DIR__ . '/../app//views/dashboard.php';
});

$router->get("404",function(){
    include_once __DIR__ . '/../app//views/404.php';
});

$router->post("/add",function(){
        print_r($_POST);
});

$router->dispatch();