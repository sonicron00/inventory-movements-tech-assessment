<?php


namespace App\Http\Controllers;

use App\Exceptions\InsufficientQuantityException;
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

    /**
     * @throws InsufficientQuantityException
     */
    public function calculateQuantity(int $productId, int $quantity): float
    {
        return $this->productService->computeFifoValueByQuantityAndProduct($productId, $quantity);
    }

    public function createOrUpdate(string $description, int $productId = 0): void
    {
        $this->productService->createOrUpdateProduct($productId, $description);
    }

    public function getProductValueByMonth(int $months, int|string $productId): array
    {
        $formatProdId = null;
        if ($productId !== "null") {
            $formatProdId = $productId;
        }
        return $this->productService->getRollingInventoryByMonth($months, $formatProdId);
    }

}