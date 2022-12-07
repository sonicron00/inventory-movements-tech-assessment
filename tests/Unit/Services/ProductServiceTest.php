<?php


namespace Tests\Unit\Services;

use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use withFaker;

    private ProductRepository $repoMock;
    private ProductService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->repoMock = Mockery::mock(ProductRepository::class);
        $this->service = new ProductService($this->repoMock);
    }

    public function testCreateOrUpdateProduct()
    {
        $id = $this->faker->randomNumber(1);
        $description = $this->faker->text(15);

        $this->repoMock->shouldReceive('updateOrCreate')
            ->once()
            ->with(
                ['id' => $id],
                ['description' => $description]
            );
        $this->service->createOrUpdateProduct($id, $description);
    }
}