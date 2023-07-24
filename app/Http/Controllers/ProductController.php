<?php


namespace App\Http\Controllers;

use App\Services\ProductService;

class ProductController extends Controller
{

    public function __construct(private readonly ProductService $productService)
    {
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
        $this->productService->createOrUpdateProduct($productId, $description);
    }

}