<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizCollection;
use App\Models\Quiz;
use Illuminate\Http\Request;
use OpenAI;
use OpenApi\Attributes as OA;

class QuizController extends Controller
{
    #[OA\Get(
        path: '/api/v1/quiz',
        operationId: 'indexQuiz',
        description: 'Get all quizzes from the database',
        summary: 'List all quizzes',
        tags: ['Quiz'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ],

    )]
    public function index(): \Illuminate\Http\JsonResponse
    {
        $quizList = Quiz::all();

        return $this->successResponse(
            data: new QuizCollection($quizList),
            message: 'Quizzes retrieved successfully.',
        );
    }

    #[OA\Post(
        path: 'api/v1/quizzes',
        operationId: 'storeQuiz',
        description: 'Store a new quiz in the database',
        summary: 'Create a new quiz',
        tags: ['Quiz'],
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ],
    )]
    public function store(Request $request): void
    {
        //
    }

    #[OA\Get(
        path: '/v1/api/quizzes/{id}',
        operationId: 'showQuiz',
        description: 'Get a quiz from the database',
        summary: 'Get a quiz',
        tags: ['Quiz'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the quiz',
                in: 'path',
                required: true,
                allowEmptyValue: false,
                schema: new OA\Schema(type: 'string'),
            ),
        ],
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ],
    )]
    public function show(string $id)
    {
        //
    }

    #[OA\Put(
        path: '/api/v1/quizzes/{id}',
        operationId: 'updateQuiz',
        description: 'Update a quiz in the database',
        summary: 'Update a quiz',
        tags: ['Quiz'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the quiz',
                in: 'path',
                required: true,
                allowEmptyValue: false,
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ],
    )]
    public function update(Request $request, string $id)
    {
        //
    }

    #[OA\Delete(
        path: '/api/v1/quizzes/{id}',
        operationId: 'destroyQuiz',
        description: 'Destroy a quiz in the database',
        summary: 'Destroy a quiz',
        tags: ['Quiz'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the quiz',
                in: 'path',
                required: true,
                allowEmptyValue: false,
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ],
    )]
    public function destroy(string $id)
    {
        //
    }

    #[OA\Get(
        path: '/api/v1/generate-quiz',
        operationId: 'generateQuiz',
        description: 'Generate a quiz using OpenAI',
        summary: 'Generate a quiz',
        tags: ['Quiz'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ],
    )]
    public function generateQuiz(Request $request): \Illuminate\Http\JsonResponse
    {
        $yourApiKey = env('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);
        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => '
            je veux que tu me generes  en francais
            un  seul quiz sur le  $skill de niveau  $niveau ,
            en structurant ta réponse de la maniere qui suit:
            Q. la question,
            (a. b. c. d. e.) comme choix de réponse (une seule réponse devrait être correcte),
            R. la réponse correcte.
            '
                ],
            ],
        ]);
        $data = $result->choices[0]->message->content;
        return response()->json(['message' => $data], 200);
    }
}
