<?php

namespace App\Http\Controllers;

use App\Services\QuestionService;

class QuestionController extends Controller
{
    public function __construct(private readonly QuestionService $questionService)
        {
        }

    public function getQuestions(): array
    {
        return $this->questionService->getAllQuestions();
    }

}