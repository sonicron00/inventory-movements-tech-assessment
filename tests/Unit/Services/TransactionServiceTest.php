<?php


namespace Tests\Unit\Services;

use App\Repositories\ApplicationRepository;
use App\Repositories\PurchaseRepository;
use App\Services\TransactionService;
use App\Services\ProductService;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use withFaker;

    private ApplicationRepository $appRepoMock;
    private PurchaseRepository $purchaseRepoMock;
    private TransactionService $tranServiceMock;
    private ProductService $prodServiceMock;
    private TransactionService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->appRepoMock = Mockery::mock(ApplicationRepository::class);
        $this->purchaseRepoMock = Mockery::mock(PurchaseRepository::class);
        $this->tranServiceMock = Mockery::mock(TransactionService::class);
        $this->prodServiceMock = Mockery::mock(ProductService::class);
        $this->service = new TransactionService($this->appRepoMock, $this->purchaseRepoMock, $this->prodServiceMock);
    }

    public function testCreateApplication()
    {
        $id = $this->faker->randomNumber(1);
        $qty = $this->faker->randomNumber(1);

        $transactionCreatePayload = [];
        $transactionCreatePayload['type'] = 'Application';
        $transactionCreatePayload['product_id'] = $id;
        $transactionCreatePayload['quantity'] = $qty * -1;

        $processedArray = $transactionCreatePayload;
        unset($processedArray['type']);


        $this->appRepoMock->shouldReceive('create')
            ->once()
            ->with(
                $processedArray
            );

        $this->service->createApplication($id, $qty);
    }

    public function testCreatePurchase()
    {
        $id = $this->faker->randomNumber(1);
        $qty = $this->faker->randomNumber(1);
        $price = $this->faker->randomNumber(2);

        $transactionCreatePayload = [];
        $transactionCreatePayload['type'] = 'Purchase';
        $transactionCreatePayload['product_id'] = $id;
        $transactionCreatePayload['qty_purchased'] = $qty;
        $transactionCreatePayload['price'] = $price;

        $processedArray = $transactionCreatePayload;
        unset($processedArray['type']);

        $this->purchaseRepoMock->shouldReceive('create')
            ->once()
            ->with(
                $processedArray
            );

        $this->service->createPurchase($id, $qty, $price);
    }

    public function testCreateInvalidType()
    {
        $id = $this->faker->randomNumber(1);
        $qty = $this->faker->randomNumber(1);
        $price = $this->faker->randomNumber(2);

        $transactionCreatePayload = [];
        $transactionCreatePayload['type'] = 'Banana';
        $transactionCreatePayload['product_id'] = $id;
        $transactionCreatePayload['qty_purchased'] = $qty;
        $transactionCreatePayload['price'] = $price;

        $this->purchaseRepoMock->shouldNotHaveBeenCalled();
        $this->appRepoMock->shouldNotHaveBeenCalled();

        $this->service->createTransaction($transactionCreatePayload);
    }
}