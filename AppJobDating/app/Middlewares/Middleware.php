<?php
namespace App\app\Middlewares;

use App\app\core\MiddlewareInterface;

class Middleware implements MiddlewareInterface
{
    public function handle(): void
    {
        if (isset($_SESSION['user'])) { // إذا مسجل دخول
            header('Location: /dashboard'); // يوجهه لـ dashboard
            exit;
        }
    }
}
