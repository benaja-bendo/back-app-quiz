<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => fake()->numberBetween(1, 50),
            'answer' => fake()->sentence(),
            'is_correct' => fake()->randomElement([0, 1]),
            'order' => fake()->numberBetween(1, 10),
        ];
    }
}
