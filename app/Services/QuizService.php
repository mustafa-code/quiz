<?php

namespace App\Services;

use App\Jobs\CalendarEventJob;
use App\Models\Quiz;
use App\Models\Tenant;
use App\Models\TenantUser;
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
}
