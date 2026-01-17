<?php
namespace App\app\Middlewares;

use App\app\core\MiddlewareInterface;

class AdminMiddleware implements MiddlewareInterface
{
    public function handle(): void
    {
        if (!isset($_SESSION['admi'])) {
            header('Location: /login');
            exit;
        }
    }
}
