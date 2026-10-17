<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Buang folder dasar (untuk XAMPP), tanpa peduli huruf besar/kecil
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
if ($basePath !== '' && stripos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

$uri = '/' . trim($uri, '/');

if ($uri === '/index.php') {
    $uri = '/';
}

$uri = strtolower($uri);

switch ($uri) {

    case '/':
        $controller = new HomeController();
        $controller->index();
        break;

    case '/products':
        $controller = new ProductController();
        $controller->index();
        break;

    case '/login':
        $controller = new AuthController();
        $controller->login();
        break;

    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    default:
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
}