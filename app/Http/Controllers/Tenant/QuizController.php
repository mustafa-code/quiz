<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\SubscribeRequest;
use App\Models\Quiz;
use App\Services\QuizService;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    private QuizService $quizService;
    
    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function subscribe(SubscribeRequest $request, Quiz $quiz)
    {
        try {
            $user = auth()->user();
            $quiz->subscribers()->attach($user->id, [
                'id' => Str::uuid()->toString(),
                'attend_time' => $request->attend_time,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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

    public function un_subscribe(Quiz $quiz)
    {
        $this->authorize('unSubscribe', $quiz);

        try {
            $user = auth()->user();
            $eventId = $quiz->subscribers()
                ->where('tenant_user_id', $user->id)
                ->first()
                ->pivot
                ->event_id;
            $quiz->subscribers()->detach($user->id);
            $this->quizService->deleteEvent($eventId);
            $success = true;
            $message = __("You have successfully unsubscribed from the quiz.");
        } catch (\Exception $e) {
            report($e);
            $success = false;
            $message = __("Something went wrong while unsubscribing from the quiz.");
        }
        return to_route('dashboard')->with([
            "message" => $message,
            "success" => $success,
        ]);
    }
}
