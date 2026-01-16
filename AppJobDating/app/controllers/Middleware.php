<?php
namespace App\app\controllers;

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
