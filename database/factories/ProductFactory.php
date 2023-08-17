<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tags;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'category_id' => function () {
                return Category::factory()->create()->id;
            },

        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $tagNames = $this->faker->words(rand(1, 5));

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $product->tags()->attach($tag);
            }
        });
    }
}
