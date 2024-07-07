<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quizzes = [
            "Culture Générale",
            "Mathématiques",
            "Sciences",
            "Géographie",
            "Histoire",
            "Littérature",
            "Musique",
            "Cinéma",
            "Sport",
            "Technologie",
            "Langues",
            "Cuisine",
            "Mode",
            "Jeux Vidéo",
            "Télévision",
            "Mythologie",
            "Nature",
            "Quiz d'Art",
            "Psychologie",
            "Politique"
        ];
        return [
            'title' => fake()->randomElement($quizzes),
            'minutes' => fake()->numberBetween(1, 20),
            'level' => fake()->randomElement(['Facile', 'Moyen', 'Difficile']),
        ];
    }
}
