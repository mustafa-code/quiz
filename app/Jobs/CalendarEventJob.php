<?php

namespace App\Jobs;

use App\Models\Quiz;
use App\Models\TenantUser;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\GoogleCalendar\Event;

class CalendarEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Quiz $quiz;
    protected $startDateTime;
    protected TenantUser $tenantUser;

    public function __construct($startDateTime, $quizId, $tenantUserId)
    {
        $this->quiz = Quiz::find($quizId);
        $this->tenantUser = TenantUser::find($tenantUserId);
        $this->startDateTime = $startDateTime;
    }

    public function handle()
    {
        $event = new Event();
        $event->name = "Quiz: " . $this->quiz->title;
        $subscription = $this->quiz->subscribers()
            ->where('tenant_user_id', $this->tenantUser->id)
            ->first();
        if ($subscription) {
            $event->startDateTime = new Carbon($subscription->pivot->attend_time);
        } else {
            $event->startDateTime = $this->startDateTime;
        }
        $event->endDateTime = new Carbon($this->quiz->end_time);

        // TODO: Fix this when complete event creation in active domain.
        // $event->addAttendee([
        //     'email' => $this->tenantUser->email,
        //     'comment' => $this->quiz->description,
        //     'name' => $this->tenantUser->name,
        // ]);

        $data = $event->save();
        $eventId = $data->id;

        $this->quiz->subscribers()
            ->where('tenant_user_id', $this->tenantUser->id)
            ->update(['event_id' => $eventId]);
    }
}
