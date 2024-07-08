<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $quiz = Quiz::create([
            'title' => 'JavaScript Quiz',
            'minutes' => 10,
            'level' => 'beginner',
        ]);

        $questionsAndAnswers = [
            [
                'question' => 'What is JavaScript?',
                'hint' => 'JavaScript is a programming language that enables you to interact with web pages.',
                'type' => 'multiple_choice',
                'order' => 1,
                'active' => 1,
                'answers' => [
                    ['answer' => 'A programming language', 'is_correct' => 1],
                    ['answer' => 'A markup language', 'is_correct' => 0],
                    ['answer' => 'A stylesheet language', 'is_correct' => 0],
                    ['answer' => 'A database language', 'is_correct' => 0],
                ],
            ],
            [
                'question' => 'What is the purpose of JavaScript?',
                'hint' => 'JavaScript is used to make web pages interactive.',
                'type' => 'multiple_choice',
                'order' => 2,
                'active' => 1,
                'answers' => [
                    ['answer' => 'To make web pages interactive', 'is_correct' => 1],
                    ['answer' => 'To style web pages', 'is_correct' => 0],
                    ['answer' => 'To store data', 'is_correct' => 0],
                    ['answer' => 'To query databases', 'is_correct' => 0],
                ],
            ],
            [
                'question' => 'What is the syntax for a single-line comment in JavaScript?',
                'hint' => 'Use two forward slashes to create a single-line comment in JavaScript.',
                'type' => 'multiple_choice',
                'order' => 3,
                'active' => 1,
                'answers' => [
                    ['answer' => '// This is a single-line comment', 'is_correct' => 1],
                    ['answer' => '/* This is a single-line comment */', 'is_correct' => 0],
                    ['answer' => '<!-- This is a single-line comment -->', 'is_correct' => 0],
                    ['answer' => '# This is a single-line comment', 'is_correct' => 0],
                ],
            ],
        ];
        foreach ($questionsAndAnswers as $qa) {
            $question = $quiz->questions()->create([
                'question' => $qa['question'],
                'hint' => $qa['hint'],
                'type' => $qa['type'],
                'order' => $qa['order'],
                'active' => $qa['active'],
            ]);

            // Boucle sur chaque réponse pour la question actuelle
            foreach ($qa['answers'] as $answer) {
                $question->answers()->create([
                    'answer' => $answer['answer'],
                    'is_correct' => $answer['is_correct'],
                ]);
            }
        }

//        \App\Models\Quiz::factory(50)->create();
//        \App\Models\Question::factory(200)->create();
//        \App\Models\Answer::factory(300)->create();
        \App\Models\User::factory(300)->create();
    }
}
