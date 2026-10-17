<?php

require_once __DIR__ . '/Controller.php';

class AuthController extends Controller
{
    public function login()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/User.php';
            require_once __DIR__ . '/../../config/database.php';

            $userModel = new User($pdo);

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header('Location: products');
                exit;
            }

            $error = 'Username atau password salah.';
        }

        $this->render('auth/login', ['error' => $error], 'Login - Kelontong Store');
    }

    public function logout()
    {
        session_destroy();

        header('Location: login');

        exit;
    }
}