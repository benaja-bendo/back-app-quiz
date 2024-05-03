<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizCollection;
use App\Models\Quiz;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/api/quizzes',
        operationId: 'indexQuiz',
        description: 'Get all quizzes from the database',
        summary: 'List all quizzes',
        tags: ['Quiz'],
        responses: [
            new OA\Response(response: 200, description: 'AOK'),
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

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/api/quiz',
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
