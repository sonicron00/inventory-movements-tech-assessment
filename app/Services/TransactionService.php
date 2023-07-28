<?php


namespace App\Services;

use App\Repositories\ApplicationRepository;
use App\Repositories\PurchaseRepository;
use Carbon\Carbon;


class TransactionService
{
    /**
     * Transaction Service
     * Business logic layer - service is responsible for handling transactions
     * @since      Class available since Release 0.0.1
     */

    public function __construct(
        public ApplicationRepository $appRepo,
        public PurchaseRepository $purchaseRepo,
    ) {
    }

    /**
     * Create a new application
     * @param int $productId
     * @param int $quantity
     * @return void
     */
    public function createApplication(int $productId, int $quantity): void
    {
        $transactionCreatePayload = [];
        $transactionCreatePayload['type'] = 'Application';
        $transactionCreatePayload['product_id'] = $productId;
        $transactionCreatePayload['quantity'] = $quantity * -1;
        $transactionCreatePayload['transaction_date'] = Carbon::now()->format('y-m-d');

        $this->createTransaction($transactionCreatePayload);
    }

    public function createPurchase(int $productId, int $quantity, float $price): void
    {
        $transactionCreatePayload = [];
        $transactionCreatePayload['type'] = 'Purchase';
        $transactionCreatePayload['product_id'] = $productId;
        $transactionCreatePayload['qty_purchased'] = $quantity;
        $transactionCreatePayload['price'] = $price;
        $transactionCreatePayload['transaction_date'] = Carbon::now()->format('y-m-d');

        $this->createTransaction($transactionCreatePayload);
    }

    /**
     * Create a new transaction by type
     * returns true on success, false on failure
     * @param array $tranData
     * @return bool
     */
    public function createTransaction(array $tranData): bool
    {
        $transactionTypeRepo = null;
        if ($tranData['type'] == 'Application') {
            $transactionTypeRepo = $this->appRepo;
        }
        if ($tranData['type'] == 'Purchase') {
            $transactionTypeRepo = $this->purchaseRepo;
        }
        if (!$transactionTypeRepo) {
            return false;
        }

        unset($tranData['type']); // No need to pass to model creation

        try {
            $transactionTypeRepo->create($tranData);
            return true;
        } catch (\Exception $exception) {
            logger($exception);
            return false;
        }
    }

    public function getAllTransactions(): array
    {
        $allTransactionsFormatted = [];
        foreach ($this->getAllApplications() as $application) {
            $allTransactionsFormatted[] = (object)[
                'product_id' => $application['product_id'],
                'transaction_date' => $application['transaction_date'],
                'transaction_type' => 'Application',
                'product_descr' => $application['products']['description'],
                'qty' => $application['quantity'],
                'price' => ''
            ];
        }
        foreach ($this->getAllPurchases() as $purchase) {
            $allTransactionsFormatted[] = (object)[
                'product_id' => $purchase['product_id'],
                'transaction_date' => $purchase['transaction_date'],
                'transaction_type' => 'Purchase',
                'product_descr' => $purchase['products']['description'],
                'qty' => $purchase['qty_purchased'],
                'price' => $purchase['price']
            ];
        }
        return $allTransactionsFormatted;
    }

    /**
     * Get all application transactions
     * @return array
     */
    public function getAllApplications(): array
    {
        return $this->appRepo->allWithRelation('products');
    }

    /**
     * Get all purchase transactions
     * @return array
     */
    public function getAllPurchases(): array
    {
        return $this->purchaseRepo->allWithRelation('products');
    }

}