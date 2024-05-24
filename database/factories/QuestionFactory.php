<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->sentence(),
            'hint' => fake()->sentence(),
            'quiz_id' => fake()->numberBetween(1, 50),
            'type' => fake()->randomElement(['multiple_choice', 'true_false']),
            'order' => fake()->numberBetween(1, 10),
            'active' => fake()->randomElement([0, 1]),
        ];
    }
}
