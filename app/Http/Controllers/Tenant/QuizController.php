<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\AttemptQuizRequest;
use App\Http\Requests\Quiz\SubscribeRequest;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizSubscriber;
use App\Services\QuizService;
use Illuminate\Http\Request;
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
            $uuid = Str::uuid()->toString();
            $quiz->subscribers()->attach($user->id, [
                'id' => $uuid,
                'attend_time' => $request->attend_time,
                'created_at' => now(),
                'updated_at' => now(),
                'quiz_link' => route('quiz.start', ['subscription' => $uuid]),
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

    public function start(QuizSubscriber $quizSubscriber)
    {
        $this->authorize('view', $quizSubscriber);

        $quiz = $quizSubscriber->quiz->load(['questions.choices' => function ($query) {
            $query->orderBy('order', 'asc'); // Assuming 'order' is the column name
        }]);

        $quizAttempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'tenant_user_id' => auth()->user()->id,
            'started_at' => now(),
        ]);
        return view('tenant.quiz.start', compact('quiz', 'quizSubscriber', 'quizAttempt'));
    }

    public function submit (AttemptQuizRequest $request, QuizSubscriber $quizSubscriber)
    {
        $data = $request->validated();

        $quizAttempt = QuizAttempt::find($data['quiz_attempt_id']);

        foreach($data['question'] as $questionId => $choiceId) {
            $quizAttempt->userAnswers()->create([
                'question_id' => $questionId,
                'choice_id' => $choiceId,
            ]);
        }
        $quizAttempt->calculateScore();

        $quizAttempt->update([
            'completed_at' => now(),
        ]);

        $this->quizService->sendResult($quizAttempt);

        // Return to result page.
        return redirect()->route('quiz.result', ['quizAttempt' => $quizAttempt]);
    }

    public function result(QuizAttempt $quizAttempt){
        return view('tenant.quiz.result', compact('quizAttempt'));
    }
}
