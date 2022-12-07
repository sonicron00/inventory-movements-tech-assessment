<?php


namespace App\Http\Controllers;

use App\Services\TransactionService;

class TransactionController
{
    protected TransactionService $tranService;

    public function __construct(TransactionService $tranService)
    {
        $this->tranService = $tranService;
    }

    public function getAllTransactions(): array
    {
        return $this->tranService->getAllTransactions();
    }

    public function getPurchases(): array
    {
        return $this->tranService->getAllPurchases();
    }

    public function getApplications(): array
    {
        return $this->tranService->getAllApplications();
    }

    public function applyQuantity(int $productId, int $quantity): void
    {
        $this->tranService->createApplication($productId, $quantity);
    }

    public function createPurchase(int $productId, int $quantity, float $price): void
    {
        $this->tranService->createPurchase($productId, $quantity, $price);
    }

}