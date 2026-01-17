<?php
namespace App\app\controller;
use App\app\core\BaseController;

// use App\models\User;

class AuthController extends Controller
{
 
    public function __construct()
    {
        parent::__construct();
        // $this->userModel = new User();
    }

    public function index(){
         $this->render('index');
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function showLogin()
    {
       

        $data = [
            'title' => 'Connexion',
            'csrf_token' => $this->security->generateCsrfToken(),
            'errors'  => $this->session->flash('errors'),
            'success' => $this->session->flash('success'),

        ];

        $this->render('auth/login', $data);
    }

    /**
     * Traite la connexion
     */
    public function login()
    {
        // var_dump($_POST);
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
            $this->redirect('/login');
        }
        else{
            $this->redirect('/dashboard');
              $this->session->flash('success', 'Connexion réussie');
        }   
    }   
}