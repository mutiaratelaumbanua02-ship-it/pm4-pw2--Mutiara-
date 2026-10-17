<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class ProductController extends Controller
{
    public function index()
    {
        AuthMiddleware::handle();

        require_once __DIR__ . '/../models/Product.php';
        require_once __DIR__ . '/../../config/database.php';

        $product = new Product($pdo);

        $products = $product->all();

        $this->render('products/index', ['products' => $products], 'Produk - Kelontong Store');
    }
}