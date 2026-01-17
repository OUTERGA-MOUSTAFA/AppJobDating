<?php

namespace App\app\core;
use App\app\core\{View,Validator,Security,Session}; // ✅ Validator
class BaseController
{

    protected $view;
    protected $security;
    protected $session;
    protected $validator;

    public function __construct()
    {
        $this->view = new View();
        $this->security = new Security();
        $this->session = Session::getInstance();
        $this->validator = new Validator();
    }

    protected function view(string $view, array $data = [])
    {
        extract($data);

        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View not found: {$viewPath}");
        }

        require $viewPath;
    }

     protected function json(array $data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    //return $this->redirect('/dashboard');

    protected function redirect(string $url, int $statusCode = 302)
    {
        http_response_code($statusCode);
        header("Location: $url");
        exit;
    }

    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data); // ✅ View of Twig
    }
    protected function verifyCsrf()
    {
        if (!$this->security->verifyCsrfToken($_POST['_token'] ?? '')) {
            $this->json(['error' => 'Invalid CSRF token'], 403);
            // http_response_code(403);
        }
    }




}