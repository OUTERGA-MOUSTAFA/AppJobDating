<?php
namespace App\app\controllers;
use App\app\core\{BaseController,Security,Session,Validator};

// use App\models\User;

class AuthController extends BaseController
{
 
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
         $this->render('index');
    }

    public function showRegister()
    {
        $data = [
            'title' => 'Connexion',
            'csrf_token' => $this->security->generateCsrfToken(),
            'errors'  => $this->session->flash('errors'),
            'success' => $this->session->flash('success'),

        ];
        // الكود ديال صفحة التسجيل
        $this->render('Auth/register', $data);
    }
    /**
     * Gère register (GET et POST)
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = [
                'title' => 'Inscription',
                'csrf_token' => $this->security->generateCsrfToken(),
            ];
            return $this->render('Auth/register', $data);
        }
        
        $this->verifyCsrf();
        
        /** TODO: Traiter l'inscription*/
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

        $this->render('Auth/login', $data);
    }

    /**
     * Traite la connexion
     * Gère login (GET et POST)
     */
    public function login()
    {
        // var_dump($_POST);
        
        // $this->verifyCsrf();

         // GET → Afficher le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = [
                'title' => 'Connexion',
                'csrf_token' => $this->security->generateCsrfToken(),
                'errors'  => $this->session->flash('errors'),
                'success' => $this->session->flash('success'),
            ];
            
            return $this->render('Auth/login', $data);
        }
        
        // POST → Traiter la connexion
        $this->verifyCsrf(); // ✅ Seulement pour POST


        
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
    
    
    public function dashboard()
    {
        $data = ['title' => 'Dashboard'];
        $this->render('dashboard', $data);
    }
}