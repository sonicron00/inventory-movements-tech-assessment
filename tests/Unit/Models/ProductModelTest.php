<?php


namespace Tests\Unit\Models;

use App\Models\Purchase;
use App\Models\Application;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ProductModelTest extends TestCase
{
    use withFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRelationshipToTransactions()
    {
        $product = factory(Product::class)->create();
        factory(Purchase::class)->create(
            [
                'product_id' => $product->id
            ]
        );
        factory(Application::class)->create(
            [
                'product_id' => $product->id
            ]
        );
        $product->refresh();
        $this->assertEquals(1, $product->purchases()->count());
        $this->assertEquals(1, $product->applications()->count());
    }


}