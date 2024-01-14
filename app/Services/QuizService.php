<?php

namespace App\Services;

use App\Models\Tenant;

class QuizService
{
    public function quizTypes()
    {
        return [
            [
                'id' => 'in-time',
                'name' => 'In Time',
            ],
            [
                'id' => 'out-of-time',
                'name' => 'Out of Time',
            ],
        ];
    }
}
