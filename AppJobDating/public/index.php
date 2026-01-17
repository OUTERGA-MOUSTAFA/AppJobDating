<?php

// root dyal projet: AppJobDating
//define('BASE_PATH', dirname(__DIR__));

// composer autoload
require_once __DIR__ . '/../../vendor/autoload.php';

use App\app\core\Router;
use App\app\controllers\HomeController;
use App\app\controllers\{Middleware, AuthMiddleware,EtudiantMiddleware, AdminMiddleware};
$router = new Router();

/**
 * Routes
 */

$router->get('/dashboard', [HomeController::class, 'dashboard'], [EtudiantMiddleware::class]);
$router->post('/dashboard', [HomeController::class, 'dashboard'], [EtudiantMiddleware::class]);
$router->get('/login', [HomeController::class, 'login'], [middleware::class]);
$router->post('/login', [HomeController::class, 'login'], [middleware::class]);
$router->get('/register', [HomeController::class, 'register'], [middleware::class]);
$router->post('/register', [HomeController::class, 'register'], [middleware::class]);

// dispatch request
$controleur = $router->dispatch();
//addRoute('dashboard', 'GET', $action);