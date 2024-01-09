<?php

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    private \App\Services\ProductService $productService;

    public function setUp(): void
    {
        parent::setUp();

        $this->productService = $this->app->make(\App\Services\ProductService::class);
    }

    public function testListAllProduct()
    {
        Product::factory()->withImage()->createMany([
            ['name' => 'test01'],
            ['name' => 'test02'],
            ['name' => 'test03']
        ]);

        $products = $this->productService->listAll();

        $this->assertEquals(3, $products->count());
        $this->seeInDatabase('products', ['name' => 'test01']);
        $this->seeInDatabase('products', ['name' => 'test02']);
        $this->seeInDatabase('products', ['name' => 'test03']);
    }

    public function testCreateAProduct()
    {
        $product = Product::factory()->withImage()->make();

        $productCreated = $this->productService->createProduct(
            $product->name,
            $product->description,
            55,
            \Illuminate\Http\UploadedFile::fake()->create("test", 125, 'jpg')
        );

        $this->assertEquals(55, $productCreated->price->getAmount());
        $this->seeInDatabase('products', ['name' => $product->name]);
    }

    public function testUpdateAProduct()
    {
        $product = Product::factory()->withImage()->create();

        $productUpdate = $this->productService->update(
            $product->id,
            'teste01',
            'test description',
            66,
            \Illuminate\Http\UploadedFile::fake()->create("test", 125, 'jpg')
        );

        Storage::disk('local')->assertMissing($product->image);
        Storage::disk('local')->assertExists($productUpdate->image);
        $this->seeInDatabase('products', ['name' => 'teste01']);
    }
}
