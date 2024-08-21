<?php

use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;

//beforeEach(function () {
//    // Utilisation du trait RefreshDatabase pour s'assurer que la base de données est réinitialisée entre chaque test
//    $this->useRefreshDatabase();
//});

/*it('can list all quizzes', function () {
    Quiz::factory()->count(3)->create();

    $response = $this->getJson('/api/v1/quizzes');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'minutes', 'level']
            ]
        ]);
});

it('can create a quiz', function () {
    $data = [
        'title' => 'New Quiz',
        'minutes' => 10,
        'level' => 'beginner'
    ];

    $response = $this->postJson('/api/v1/quizzes', $data);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'title' => 'New Quiz',
                'minutes' => 10,
                'level' => 'beginner'
            ],
            'message' => 'Quiz created successfully.'
        ]);

    $this->assertDatabaseHas('quizzes', $data);
});

it('can update a quiz', function () {
    $quiz = Quiz::factory()->create();

    $data = [
        'title' => 'Updated Quiz',
        'minutes' => 15,
        'level' => 'intermediate'
    ];

    $response = $this->putJson("/api/v1/quizzes/{$quiz->id}", $data);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'title' => 'Updated Quiz',
                'minutes' => 15,
                'level' => 'intermediate'
            ],
            'message' => 'Quiz updated successfully.'
        ]);

    $this->assertDatabaseHas('quizzes', $data);
});

it('can show a quiz', function () {
    $quiz = Quiz::factory()->create();

    $response = $this->getJson("/api/v1/quizzes/{$quiz->id}");

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'minutes' => $quiz->minutes,
                'level' => $quiz->level,
            ],
            'message' => 'Quiz retrieved successfully.'
        ]);
});

it('can delete a quiz', function () {
    $quiz = Quiz::factory()->create();

    $response = $this->deleteJson("/api/v1/quizzes/{$quiz->id}");

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Quiz deleted successfully.'
        ]);

    $this->assertDatabaseMissing('quizzes', ['id' => $quiz->id]);
});*/

//it('can access the quizzes index route', function () {
//    Route::shouldReceive('get')
//        ->with('/api/v1/quizzes')
//        ->andReturn('indexQuiz');
//
//    $response = $this->getJson('/api/v1/quizzes');
//
//    $response->assertStatus(200);
//});
