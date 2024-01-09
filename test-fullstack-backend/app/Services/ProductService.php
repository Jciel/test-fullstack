<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Money\Money;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ProductService
{
    public function __construct()
    {
    }

    /**
     * @return Collection
     */
    public function listAll(): Collection
    {
        return Product::all();
    }

    /**
     * @param string $name
     * @param string $description
     * @param int $price
     * @param UploadedFile $image
     * @return Product
     */
    public function createProduct(string $name, string $description, int $price, UploadedFile $image): Product
    {
        $path = $image->store('products', 'local');

        if (!$path) {
            throw new UnprocessableEntityHttpException('Error when trying to save image product');
        }

        $product = Product::create([
            'name'  => $name,
            'description' => $description,
            'price' => Money::BRL($price),
            'image' => $path
        ]);

        if ($product) {
            return $product;
        }

        throw new UnprocessableEntityHttpException('Error when trying to register product');
    }

    public function update(
        string $id,
        string $name = null,
        string $description = null,
        int $price = null,
        UploadedFile $image = null
    ): Product {
        $product = Product::findOrFail($id);

        $product->update(['name' => $name, 'description' => $description, 'price' => Money::BRL($price)]);

        if ($image) {
            Storage::disk('local')->delete("products/{$product->image}");
            $path = $image->store('products', 'local');
            $product->update(['image' => $path]);
        }

        return $product;
    }
}
