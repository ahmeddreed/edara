<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'price' => Str::random(4),
            'description' => fake()->text(),
            'note' => fake()->text(),
            'user_id' => 1,
            'remember_token' => Str::random(10),
        ];
    }
}
