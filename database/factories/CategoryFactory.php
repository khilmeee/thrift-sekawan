<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $category_name = $this->faker->unique()->words($nb=2,$asText = true);
        $slug = Str::slug($category_name);
        return [
            'name' => Str::title($category_name),
            'slug'=>$slug,
            'image' => $this->faker->numberBetween(1,6).'.jpg'
        ];
    }
}
