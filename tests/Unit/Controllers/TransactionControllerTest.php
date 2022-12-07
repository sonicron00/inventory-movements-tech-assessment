<?php


namespace Tests\Unit\Controllers;

use App\Services\TransactionService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use withFaker;

    private TransactionService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = \Mockery::mock(TransactionService::class);
        app()->instance(TransactionService::class, $this->service);
    }

    public function testGetPurchases()
    {
        $this->service->shouldReceive('getAllPurchases')->once();
        $this->get('/api/purchases');
    }

    public function testGetApplications()
    {
        $this->service->shouldReceive('getAllApplications')->once();
        $this->get('/api/applications');
    }

    public function testGetAllTransactions()
    {
        $this->service->shouldReceive('getAllTransactions')->once();
        $this->get('/api/transactions');
    }

    public function testApplyQuantity()
    {
        $data = [
            "id" => $this->faker->randomNumber(1),
            "qty" => $this->faker->randomNumber(2)
        ];
        $this->service->shouldReceive('createApplication')->with($data['id'], $data['qty'])->once();
        $this->put(
            '/api/products/apply/' . $data['id'] . '/' . $data['qty']
        );
    }
}