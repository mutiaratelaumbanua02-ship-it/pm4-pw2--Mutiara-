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
    public function register()
    {
        $error = null;
        $old = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/User.php';
            require_once __DIR__ . '/../../config/database.php';

            $userModel = new User($pdo);

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm'] ?? '';
            $old = $username;

            if ($username === '' || $password === '') {
                $error = 'Username dan password wajib diisi.';
            } elseif (strlen($username) < 3) {
                $error = 'Username minimal 3 karakter.';
            } elseif (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter.';
            } elseif ($password !== $confirm) {
                $error = 'Konfirmasi password tidak sama.';
            } elseif ($userModel->findByUsername($username)) {
                $error = 'Username sudah dipakai.';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $userModel->create($username, $hash);

                header('Location: login');
                exit;
            }
        }

        $this->render('auth/register', ['error' => $error, 'old' => $old], 'Daftar - Kelontong Store');
    }
    public function logout()
    {
        session_destroy();

        header('Location: login');

        exit;
    }
}