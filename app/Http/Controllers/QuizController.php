<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizCollection;
use App\Models\Quiz;
use Illuminate\Http\Request;
use OpenAI;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class QuizController extends Controller
{
    #[OA\Get(
        path: '/api/v1/quizzes',
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
        path: '/api/v1/quizzes',
        operationId: 'storeQuiz',
        description: 'Store a new quiz in the database',
        summary: 'Create a new quiz',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'minutes', 'level'],
            )),
        tags: ['Quiz'],
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 401, description: 'Not allowed'),
            new OA\Response(response: 422, description: 'Validation error')
        ]
    )]
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'minutes' => 'required|int',
                'level' => 'required|string',
            ]);

            $quiz = Quiz::create([
                'title' => $validatedData['title'],
                'minutes' => $validatedData['minutes'],
                'level' => $validatedData['level']
            ]);

            return response()->json([
                'data' => $quiz,
                'message' => 'Quiz created successfully.',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Validation failed.',
            ], 422);
        }
    }

    #[OA\Put(
        path: '/api/v1/quizzes/{id}',
        operationId: 'UpdateQuiz',
        description: 'Store and updated quiz in the database',
        summary: 'Update a quiz',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'minutes', 'level'],
            )),
        tags: ['Quiz'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the quiz',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 401, description: 'Not allowed'),
            new OA\Response(response: 422, description: 'Validation error')
        ]
    )]
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'minutes' => 'required|int',
                'level' => 'required|string',
            ]);

            $quiz = Quiz::find($id);
            $quiz->update([
                'title' => $validatedData['title'],
                'minutes' => $validatedData['minutes'],
                'level' => $validatedData['level']
            ]);

            return response()->json([
                'data' => $quiz,
                'message' => 'Quiz updated successfully.',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Validation failed.',
            ], 422);
        }
    }

    #[OA\Get(
        path: '/api/v1/quizzes/{id}',
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
            new OA\Response(response: 200, description: 'Ok'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ],
    )]
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json([
                'message' => 'Quiz not found',
            ], 404);
        }

        return $this->successResponse(
            data: $quiz,
            message: 'Quiz retrieved successfully.',
        );
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
                schema: new OA\Schema(type: 'string')
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Not allowed'),
            new OA\Response(response: 404, description: 'Quiz not found')
        ],
    )]
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $quiz->delete();

            return response()->json([
                'message' => 'Quiz deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Quiz not found.',
            ], 404);
        }
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
