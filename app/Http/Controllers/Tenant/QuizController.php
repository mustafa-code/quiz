<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Services\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private QuizService $quizService;
    
    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function subscribe(Quiz $quiz)
    {
        $this->authorize('subscribe', $quiz);
        $this->authorize('subscribable', $quiz);

        try {
            $user = auth()->user();
            $quiz->subscribers()->attach($user->id);
            $this->quizService->sendEvent($quiz->id, $user->id);
            $success = true;
            $message = __("You have successfully subscribed to the quiz.");
        } catch (\Exception $e) {
            report($e);
            $success = false;
            $message = __("Something went wrong while subscribing to the quiz.");
        }
        return to_route('dashboard')->with([
            "message" => $message,
            "success" => $success,
        ]);
    }
}
