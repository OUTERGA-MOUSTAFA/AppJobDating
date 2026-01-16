<?php

namespace App\app\controllers;

use App\app\core\BaseController;

class HomeController extends BaseController
{
    public function showDashboard()
    {
         $data = [
            'title' => 'Dashboard'
        ];

        return $this->view('dashboard', $data);
    }
    

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['user'] = [
                'id' => 1,
                'name' => 'Godass'
            ];

            return $this->redirect('/dashboard');
        }

        return $this->view('login');
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect('/login');
    }
}