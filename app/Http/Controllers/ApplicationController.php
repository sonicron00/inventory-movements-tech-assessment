<?php


namespace App\Http\Controllers;


use App\Services\TransactionService;

class ApplicationController
{
    protected TransactionService $tranService;

    public function __construct(TransactionService $tranService)
    {
        $this->tranService = $tranService;
    }

    public function getApplications(): array
    {
        return $this->tranService->getAllApplications();
    }

}