<?php


namespace App\Services;

use App\Repositories\ApplicationRepository;
use App\Repositories\PurchaseRepository;


class TransactionService
{
    /**
     * Transaction Service
     * Business logic layer - service is responsible for handling transactions
     * @since      Class available since Release 0.0.1
     */


    public ApplicationRepository $appRepo;
    public PurchaseRepository $purchaseRepo;

    /**
     * Transaction Service constructor.
     *
     * @param ApplicationRepository $appRepo
     * @param PurchaseRepository $purchaseRepo
     */
    public function __construct(ApplicationRepository $appRepo, PurchaseRepository $purchaseRepo)
    {
        $this->appRepo = $appRepo;
        $this->purchaseRepo = $purchaseRepo;
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

        try {
            $transactionTypeRepo->create($tranData);
            return true;
        } catch (\Exception $exception) {
            logger($exception);
            return false;
        }
    }

    /**
     * Get all application transactions
     * @return array
     */
    public function getAllApplications(): array
    {
        return $this->appRepo->all();
    }

    /**
     * Get all purchase transactions
     * @return array
     */
    public function getAllPurchases(): array
    {
        return $this->purchaseRepo->all();
    }

}