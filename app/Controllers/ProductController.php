<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

/**
 * // --- Ürün işlemleri
 */
class ProductController extends BaseController
{
    private Product $products;
    private Category $categories;

    public function __construct()
    {
        parent::__construct();
        $this->products = new Product();
        $this->categories = new Category();
    }

    /**
     * // --- Ürün listesi
     * @return void
     */
    public function index(): void
    {
        $items = $this->products->where();
        $this->render('products/index', [
            'title' => 'Ürünler',
            'products' => $items,
        ]);
    }

    /**
     * // --- Ürün detay
     * @param string $slug
     * @return void
     */
    public function show(string $slug): void
    {
        $results = $this->products->where(['slug' => $slug]);
        $product = $results[0] ?? null;

        if (!$product) {
            $this->response->setStatusCode(404);
            echo 'Ürün bulunamadı';
            return;
        }

        $this->render('products/show', [
            'title' => (string) $product['title'],
            'product' => $product,
        ]);
    }
}
