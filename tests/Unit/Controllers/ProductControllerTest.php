<?php


namespace Tests\Unit\Controllers;

use App\Services\ProductService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ProductControllerTest extends TestCase
{
    use withFaker;

    private ProductService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = \Mockery::mock(ProductService::class);
        app()->instance(ProductService::class, $this->service);
    }

    public function testGetProducts()
    {
        $this->service->shouldReceive('getAllProductsWithQuantity')->once();
        $this->get('/api/products');
    }

    public function testCalculateQuantity()
    {
        $data = [
            "id" => $this->faker->randomNumber(1),
            "qty" => $this->faker->randomNumber(2)
        ];
        $this->service->shouldReceive('computeFifoValueByQuantityAndProduct')->with($data['id'], $data['qty'])->once();
        $this->get(
            '/api/products/preapply/' . $data['id'] . '/' . $data['qty']
        );
    }
}