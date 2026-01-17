<?php
namespace App\app\Middlewares;

use App\app\Core\MiddlewareInterface;


class AuthMiddleware implements Middleware {
    public function handle() {

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit(); // out 
        }
    }
}