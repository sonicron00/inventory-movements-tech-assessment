<?php


namespace App\Http\Controllers;

use App\Services\ProductService;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProducts(): array
    {
        return $this->productService->getAllProductsWithQuantity();
    }

    public function applyQuantity(int $productId)
    {
        return $this->productService->computeFifoValueByQuantityAndProduct($productId, 10);
    }

}