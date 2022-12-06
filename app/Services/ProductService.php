<?php


namespace App\Services;

use App\Repositories\ProductRepository;
use App\Exceptions\InsufficientQuantityException;

class ProductService
{
    /**
     * Product Service
     * Business logic layer - service is responsible for handling product logic
     * and provides quantity and value computations
     * @since      Class available since Release 0.0.1
     */

    public ProductRepository $productRepo;

    /**
     * Product Service constructor.
     *
     * @param ProductRepository $productRepo
     */
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * Create or modify a product record
     * returns true on success, false on failure
     * @param array $productData
     * @return bool
     */
    public function createOrUpdateProduct(array $productData): bool
    {
        try {
            $this->productRepo->updateOrCreate(['id' => $productData['id']], $productData);
            return true;
        } catch (\Exception $exception) {
            logger($exception);
            return false;
        }
    }

    /**
     * Get all products
     * @return array
     */
    public function getAllProducts(): array
    {
        return $this->productRepo->all();
    }

    /**
     * Get all products with quantity
     * Returns an array of product data with current quantity computation
     * @return array
     */
    public function getAllProductsWithQuantity(): array
    {
        $productDetail = [];
        $allProducts = $this->productRepo->all();
        foreach ($allProducts as $product) {
            array_push(
                $productDetail,
                [
                    'productID' => $product->id,
                    'description' => $product->description,
                    'quantity' => $this->getAvailableQuantityByProduct($product->id)
                ]
            );
        }
        return $productDetail;
    }

    /**
     * Compute 'FIFO' (first in first out) value for requested application quantity
     * Returns an monetary value being the requested application quantity calculated
     * from utilising purchase prices on a FIFO basis
     * By requesting all purchases in date ascending order
     * @param int $productId
     * @param int $quantity
     * @return float
     * @throws InsufficientQuantityException
     */
    public function computeFifoValueByQuantityAndProduct(int $productId, int $quantity): float
    {
        $value = 0.00;
        $quantityToApply = $quantity;

        $maxQuantity = $this->getAvailableQuantityByProduct($productId);
        $purchases = $this->productRepo->getPurchasesByProductOrderedByDate($productId, 'asc');

        if ($quantity > $maxQuantity) {
            throw new InsufficientQuantityException();
        }

        foreach ($purchases as $purchase) {
            // Purchase exceeds requirement (partially applied)
            if ($purchase->quantity > $quantityToApply) {
                $value += $quantityToApply * $purchase->price;
                $quantityToApply = 0;
                break;
            }

            // Requirement exceeds purchase (fully applied)
            if ($quantityToApply > $purchase->quantity) {
                $value += $purchase->quantity * $purchase->price;
                $quantityToApply -= $purchase->quantity;
                continue;
            }
        }

        return $value;
    }

    /**
     * Get available quantity for a given product
     * Returns computed current quantity based on all transactions for the product
     * @param int $productId
     * @return int
     */
    private function getAvailableQuantityByProduct(int $productId): int
    {
        $transactions = $this->productRepo->getAllTransactionsByProduct($productId);
        $quantity = 0;
        foreach ($transactions['applications'] as $application) {
            $quantity += $application->quantity;
        }
        foreach ($transactions['purchases'] as $purchase) {
            $quantity += $purchase->quantity;
        }
        return $quantity;
    }

}