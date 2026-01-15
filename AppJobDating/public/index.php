<?php

// root dyal projet: AppJobDating
//define('BASE_PATH', dirname(__DIR__));

// composer autoload
require_once __DIR__ . '/../../vendor/autoload.php';

use App\app\core\Router;

$router = new Router();

/**
 * Routes
 */
$router->get('/dashboard', function () {
    //require BASE_PATH . '/app/views/dashboard.php';
    require BASE_PATH . '/app/core/BaseController.php';
});



$router->get('/login', function () {
    require BASE_PATH . '/app/views/login.php';
});

$router->post('/login', function () {
    require BASE_PATH . '/app/views/login.php';
});


$router->get('/404', function () {
    require BASE_PATH . '/app/views/404.php';
});

$router->get('/register', function () {
    require BASE_PATH . '/app/views/register.php';
});
$router->post('/register', function () {
    require BASE_PATH . '/app/views/register.php';
});

// dispatch request
$controleur = $router->dispatch();
//addRoute('dashboard', 'GET', $action);