<?php

namespace Database\Factories;

use App\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Money\Money;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(200),
            'price' => Money::BRL($this->faker->numberBetween(100, 1000)),
        ];
    }

    public function withImage()
    {
        return $this->state(function (array $attributes) {
            return [
                'image' => $this->faker->image(storage_path('app/products'), 400, 300, null, false),
            ];
        });
    }
}
