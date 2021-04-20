<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->randomDigit,
            'title' => 'test product',
            'content' => $this->faker->word,
            'price' => $this->faker->numberBetween(15000, 30000),
            'quantity' => $this->faker->numberBetween(10, 20)
        ];
    }

    public function less()
    {
        return $this->state(function(array $attributes) {
            return [
                'quantity' => 1
            ];
        });
    }
}
