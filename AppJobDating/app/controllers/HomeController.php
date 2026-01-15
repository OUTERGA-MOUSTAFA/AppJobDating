<?php

namespace App\app\controllers;
use App\app\core\BaseController;

class HomeController extends BaseController
{
    public function dashboard()
    {
        // تحضير البيانات
        $data = [
            'title' => 'Dashboard',
            'users' => ['Ahmed', 'Sara', 'Yassine'],
            'total' => 1240
        ];
        
        // عرض الصفحة
        $this->render('dashboard', $data);
    }
    
}