<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function subscribe(Quiz $quiz)
    {
        // Check if current user is already subscribed to the quiz.
        if ($quiz->subscribers()->where('tenant_user_id', auth()->user()->id)->exists()) {
            return to_route('dashboard')->with([
                "message" => __("You are already subscribed to the quiz."),
                "success" => false,
            ]);
        }

        try {
            $quiz->subscribers()->attach(auth()->user()->id);
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
