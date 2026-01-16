<?php

namespace App\app\Controllers;

use App\app\Core\BaseController;

class Front extends BaseController
{
    
}


use App\app\core\Controller;
use App\app\core\Auth;
use App\app\models\User;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function showLogin()
    {
        if (Auth::check()) {
            $this->view('/');
        }

        $data = [
            'title' => 'Connexion',
            'csrf_token' => $this->security->generateCsrfToken()
        ];

        $this->render('front/auth/login', $data);
    }

    /**
     * Traite la connexion
     */
    public function login()
    {
        $this->verifyCsrf();

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validation
        $isValid = $this->validator->validate($_POST, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (!$isValid) {
            $this->session->flash('errors', $this->validator->errors());
            $this->view('/login');
        }

        // Tentative de connexion
        if (Auth::attempt($email, $password)) {
            $this->session->flash('success', 'Connexion réussie');
            $this->view('/');
        } else {
            $this->session->flash('error', 'Identifiants incorrects');
            $this->view('/login');
        }
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegister()
    {
        if (Auth::check()) {
            $this->view('/');
        }

        $data = [
            'title' => 'Inscription',
            'csrf_token' => $this->security->generateCsrfToken()
        ];

        $this->render('front/auth/register', $data);
    }

    /**
     * Traite l'inscription
     */
    public function register()
    {
        $this->verifyCsrf();

        // Validation
        $isValid = $this->validator->validate($_POST, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        if (!$isValid) {
            $this->session->flash('errors', $this->validator->errors());
            $this->view('/register');
        }

        // Création de l'utilisateur
        $userId = $this->userModel->create([
            'name' => $this->security->sanitize($_POST['name']),
            'email' => $this->security->sanitizeEmail($_POST['email']),
            'password' => $this->security->hashPassword($_POST['password']),
            'role' => 'user'
        ]);

        if ($userId) {
            $this->session->flash('success', 'Inscription réussie, vous pouvez vous connecter');
            $this->view('/login');
        } else {
            $this->session->flash('error', 'Erreur lors de l\'inscription');
            $this->view('/register');
        }
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        Auth::logout();
        $this->view('/');
    }
}