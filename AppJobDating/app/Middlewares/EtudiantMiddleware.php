<?php
namespace App\app\Middlewares;

use App\app\core\MiddlewareInterface;

class EtudiantMiddleware implements MiddlewareInterface
{
    public function handle() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
