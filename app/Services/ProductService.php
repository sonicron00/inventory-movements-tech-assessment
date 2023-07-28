<?php


namespace App\Services;

use App\Repositories\ProductRepository;
use App\Exceptions\InsufficientQuantityException;
use Carbon\Carbon;

class ProductService
{
    /**
     * Product Service
     * Business logic layer - service is responsible for handling product logic
     * and provides quantity and value computations
     * @since      Class available since Release 0.0.1
     */


    public function __construct(
        private readonly ProductRepository $productRepo,
        private readonly TransactionService $transactionService
    ) {
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
     * Returns a monetary value being the requested application quantity calculated
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
     * @param string|null $dataPoint
     * @return int
     */
    private function getAvailableQuantityByProduct(int $productId, string $dataPoint = null): int
    {
        $transactions = $this->productRepo->getAllTransactionsByProduct($productId);
        $quantity = 0;
        foreach ($transactions['applications'] as $application) {
            if (($dataPoint && $application->transaction_date < $dataPoint) || !$dataPoint) {
                $quantity += $application->quantity;
            }
        }
        foreach ($transactions['purchases'] as $purchase) {
            if (($dataPoint && $purchase->transaction_date < $dataPoint) || !$dataPoint) {
                $quantity += $purchase->qty_purchased;
            }
        }
        return $quantity;
    }

    /**
     * Get cumulative quantity on hand - for month period, by product (or all)
     * Returns computed monthly quantity held at each datapoint (month)
     * @param int $months
     * @param int|null $productId
     * @return array
     */
    public function getRollingInventoryByMonth(int $months, int $productId = null): array
    {
        $allTransactions = $this->transactionService->getAllTransactions();
        $rangeStart = Carbon::now()->subMonths($months);
        $startingQty = 0;
        if (!$productId) {
            $products = $this->productRepo->all();
            foreach ($products as $product) {
                $startingQty += $this->getAvailableQuantityByProduct($product->id, $rangeStart);
            }
        }
        if ($productId) {
            $startingQty += $this->getAvailableQuantityByProduct($productId, $rangeStart);
        }
        $monthTicker = $months - 1;
        $monthsArray = [];
        $dataArray = [];
        $rollingBalance = $startingQty;
        while ($monthTicker >= 0) {
            $monthNetMovement = 0;
            $monthStart = Carbon::now()->subMonths($monthTicker)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($monthTicker)->endOfMonth();
            foreach ($allTransactions as $transaction) {
                if (!$productId) {
                    if ($transaction->transaction_date > $monthStart && $transaction->transaction_date < $monthEnd) {
                        $monthNetMovement += $transaction->qty;
                    }
                }
                if ($productId) {
                    if ($transaction->product_id == $productId &&
                        $transaction->transaction_date > $monthStart &&
                        $transaction->transaction_date < $monthEnd) {
                        $monthNetMovement += $transaction->qty;
                    }
                }
            }
            $monthPosition = $rollingBalance + $monthNetMovement;
            $monthsArray[] = Carbon::now()->subMonths($monthTicker)->shortMonthName .'-'. Carbon::now()->subMonths($monthTicker)->year;
            $dataArray[] = $monthPosition;
            $rollingBalance += $monthNetMovement;
            $monthTicker--;

        }
        return array('months' => $monthsArray, 'data' => $dataArray);
    }

}