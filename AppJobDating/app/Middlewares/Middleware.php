<?php
namespace App\app\Middlewares;

use App\app\Core\MiddlewareInterface;

class Middleware implements MiddlewareInterface
{
    public function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
}
