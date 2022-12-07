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

    public function calculateQuantity(int $productId, int $quantity): float
    {
        return $this->productService->computeFifoValueByQuantityAndProduct($productId, $quantity);
    }

    public function createOrUpdate(string $description, int $productId = 0): void
    {
        $this->productService->updateProductDescription($productId, $description);
    }

}