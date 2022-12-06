<?php


namespace App\Http\Controllers;


use App\Services\TransactionService;

class PurchaseController
{
    protected TransactionService $tranService;

    public function __construct(TransactionService $tranService)
    {
        $this->tranService = $tranService;
    }

    public function getPurchases(): array
    {
        return $this->tranService->getAllPurchases();
    }

}