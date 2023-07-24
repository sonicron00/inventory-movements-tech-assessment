<?php

namespace App\Services;

use App\Repositories\QuestionRepository;

class QuestionService
{
    public function __construct(private readonly QuestionRepository $questionRepo)
    {
    }

    public function getAllQuestions(): array
    {
        return $this->questionRepo->all()->toArray();
    }

}