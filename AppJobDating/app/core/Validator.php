<?php
namespace App\app\core;
use App\models\cheking;
// var_dump($_POST);
use App\app\config\config;
use App\app\core\BaseModel;

class Validator extends BaseModel {

    public function login() {
        $email = strip_tags(trim($_POST['email'] ?? ''));
        $password = strip_tags(trim($_POST['password'] ?? ''));
        $errors = [];
        if(empty($email)){
            $errors []= "Email est obligatoire!";
        }
        if(empty($password)){
            $errors []= "Password est obligatoire!";
        }
        $check = new cheking();
        $emailResult = $check->checkEmail($email);
        if (!$emailResult) {
            $errors[] = "Email pas correct";
        } else {
            $passResult = $check->checkPassword($email);

            if (!password_verify($password, $passResult['password_hash'])) {
                $errors[] = "Password pas correct";
            }
        }
                // redirigé vers
        if (!empty($errors)) {
            // function li dakhel class khem biha 
            $this->showLogin($errors);
            exit();
        }elseif(empty($errors)) {
            $getCin = new cheking();
            $CIN= $getCin->getCIN($email);

            $_SESSION['cin'] = $CIN['CIN'];
            $_SESSION['login'] = 'ok';
            $_SESSION['email'] = $email;

            echo "<script>alert('Connexion réussie')'</script>";
            header('Location: ' . BASE_PATH . '/dashboard');
            exit();
        }else{
        header('location:'. BASE_PATH . '/login');
        exit();
        }
    }


    public function register() {
        // Récupération et nettoyage
        $cin = trim($_POST['cin'] ?? '');
        $name = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm_password = $_POST['confirm_password'] ?? '';

        $errors = [];

        // Validations
        if (empty($cin)) {
            $errors[] = "Le champ CIN est obligatoire";
        }

        if (empty($name)) {
            $errors[] = "Le champ name est obligatoire";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide ou vide";
        }

        if (empty($password)) {

            $errors[] = "Le champ Password est obligatoire";

        } elseif (strlen($password) < 8) {

            $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
        }

        if (empty($confirm_password)) {
            $errors[] = "Veuillez confirmer le mot de passe";
        } elseif ($password !== $confirm_password) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }
        // Vérifier le doublement email en DB
        
        $checkInfo = new cheking();
        $checkExist = $checkInfo->checkEmail($email);
        var_dump($checkExist);
        
        if($checkExist != false){
            if ($checkExist['email'] === $email) {
            $errors[] = "Email déjà utilisé";
            }
            if($checkExist['CIN'] === $cin){
                $errors[] = "CIN déjà utilisé";
            }
        }
        
        // Si aucune erreur → insertion
        if (!empty($errors)) {
            // function li dakhel class khem biha 
            $this->showRegister($errors);
            exit();

        }elseif(empty($errors)) {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userClass = new User($cin, $name, $email, $hashedPassword);
            $result = $userClass->AddUser();
            if($result === true){
                $_SESSION['name'] = $name;
                $_SESSION['cin'] = $cin;
                $array = [];
                $this->showLogin($array);
            }
            echo "<script>alert('Inscription réussie') window.location.href = '/login';</script>";
            exit();
        }else{
        header('Location: ' . BASE_PATH . '/register');
        exit();
        }
    }

    
}