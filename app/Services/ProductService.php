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


    public function __construct( private readonly ProductRepository $productRepo)
    {
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
            $productDetail[] = [
                'productID' => $product->id,
                'description' => $product->description,
                'quantity' => $this->getAvailableQuantityByProduct($product->id)
            ];
        }
        return $productDetail;
    }

    public function createOrUpdateProduct(int $productId, string $description): void
    {
        $this->productRepo->updateOrCreate(['id' => $productId], ['description' => $description]);
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
            $purchasedAmountUnapplied = ($purchase->qty_purchased - $purchase->qty_applied);

            // Purchase exceeds requirement (partially applied)
            if ($purchasedAmountUnapplied > $quantityToApply) {
                $value += $quantityToApply * $purchase->price;
                $quantityToApply = 0;
                break;
            }

            // Requirement exceeds purchase (fully applied)
            if ($quantityToApply > $purchasedAmountUnapplied) {
                $value += $purchasedAmountUnapplied * $purchase->price;
                $quantityToApply -= $purchasedAmountUnapplied;
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
            $quantity += $purchase->qty_purchased;
        }
        return $quantity;
    }

}