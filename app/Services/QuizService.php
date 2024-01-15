<?php

namespace App\Services;

use App\Jobs\CalendarDeleteEventJob;
use App\Jobs\CalendarEventJob;
use App\Jobs\SendEmailJob;
use App\Models\QuizAttempt;
use Carbon\Carbon;

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

    public function sendEvent($quizId, $tenantUserId)
    {
        $startDateTime = Carbon::now();
        CalendarEventJob::dispatch(
            $startDateTime, $quizId, $tenantUserId,
        )->onQueue('calendar-events');
    }

    public function deleteEvent($eventId)
    {
        CalendarDeleteEventJob::dispatch($eventId)
        ->onQueue('calendar-events');
    }

    public function sendResult(QuizAttempt $quizAttempt)
    {
        SendEmailJob::dispatch([
            'template' => 'emails.quiz-result',
            'subject' => 'Quiz Result: '.$quizAttempt->quiz->name,
            'to' => $quizAttempt->tenantUser->email,
            'parameters' => [
                'quizAttempt' => $quizAttempt,
            ],
        ])->onQueue('emails');

    }
}
