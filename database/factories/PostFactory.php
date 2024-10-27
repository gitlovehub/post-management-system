<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'         => fake()->unique()->word,
            'excerpt'       => fake()->sentence(3),
            'description'   => fake()->paragraph(),
            'view'          => rand(0, 100),
            'status'        => 'published',
            'category_id'   => rand(1, 5),
            'user_id'       => rand(1, 10),
        ];
    }
}
