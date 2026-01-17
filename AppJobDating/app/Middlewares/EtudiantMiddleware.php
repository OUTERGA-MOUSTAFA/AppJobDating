<?php
namespace App\app\Middlewares;

use App\app\Core\MiddlewareInterface;

class EtudiantMiddleware implements MiddlewareInterface
{
    public function handle() {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }
    }
}
