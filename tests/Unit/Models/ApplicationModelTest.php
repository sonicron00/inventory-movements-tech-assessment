<?php


namespace Tests\Unit\Models;

use App\Models\Application;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ApplicationModelTest extends TestCase
{
    use withFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRelationshipToProduct()
    {
        $product = factory(Product::class)->create();
        factory(Application::class)->create(
            [
                'product_id' => $product->id
            ]
        );
        $product->refresh();
        $this->assertEquals(1, $product->applications()->count());
    }


}