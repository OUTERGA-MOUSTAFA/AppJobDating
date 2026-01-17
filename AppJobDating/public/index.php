<?php

// root dyal projet: AppJobDating
//define('BASE_PATH', dirname(__DIR__));

// composer autoload
require_once __DIR__ . '/../../vendor/autoload.php';

use App\app\core\Router;
use App\app\controllers\AuthController;
use App\app\Middlewares\{Middleware, AuthMiddleware,EtudiantMiddleware, AdminMiddleware};
$router = new Router();

/**
 * Routes
 */

$router->get('/dashboard', [AuthController::class, 'dashboard'], [EtudiantMiddleware::class]);
$router->post('/dashboard', [AuthController::class, 'dashboard'], [EtudiantMiddleware::class]);
$router->get('/login', [AuthController::class, 'showLogin'], [Middleware::class]);
$router->post('/login', [AuthController::class, 'login'], [Middleware::class]);
$router->get('/register', [AuthController::class, 'showRegister'], [Middleware::class]);
$router->post('/register', [AuthController::class, 'register'], [Middleware::class]);

// dispatch request
$controleur = $router->dispatch();
//addRoute('dashboard', 'GET', $action);