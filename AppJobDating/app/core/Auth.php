<?php


// first entre app
if ($uri === '/' || $uri === '') {
    if (empty($_SESSION['email'])) {
        header('Location: ' . BASE_PATH . '/register');
        exit();
    }elseif($_SESSION['login'] !== 'ok'){
        header('Location: ' . BASE_PATH . '/login');
        exit();
    } else {
        header('Location: ' . BASE_PATH . '/dashboard');
        exit();
    }
}

function logout() {
    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to login page
    header('Location: /../views/register.php');
    exit();
}