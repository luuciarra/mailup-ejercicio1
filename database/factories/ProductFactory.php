<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(4, 200, 1000);
        $discount = $this->faker->numberBetween(10, 50);
        $name = $this->faker->word();

        return [
            "name" => $name,
            "image" => $this->faker->imageUrl(640, 480, $name, true, "image"),
            "brand" => $this->faker->randomElement(config("products.brands", [])),
            "category" => $this->faker->randomElement(config("products.categories", [])),
            "description" => implode("<br><br>", $this->faker->sentences(rand(1,6))),
            "price" => $price,
            "discount" => $discount,
            "price_sale" => $price - ($discount * $price / 100),
            "stock" => rand(0, 10) ? $this->faker->numberBetween(1,20) : 0,
        ];
    }
}
