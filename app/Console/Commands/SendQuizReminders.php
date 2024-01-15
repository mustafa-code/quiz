<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Models\QuizSubscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendQuizReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-quiz-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for quizzes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenMinutesFromNow = Carbon::now()->addMinutes(10);

        QuizSubscriber::where('reminder_sent', false)
            ->where('attend_time', '<=', $tenMinutesFromNow)
            ->each(function ($subscription) {
                // Logic to send reminder (e.g., email, notification)
                SendEmailJob::dispatch([
                    'template' => 'emails.quiz-reminder',
                    'subject' => 'Reminder: Quiz is about to start',
                    'to' => $subscription->tenantUser->email,
                    'parameters' => [
                        'quiz' => $subscription->quiz,
                        'tenantUser' => $subscription->tenantUser,
                        'startTime' => $subscription->attend_time,
                        'tenantName' => $subscription->quiz->tenant->name,
                        'quizLink' => $subscription->quiz_link,
                    ],
                ])->onQueue('emails');
    
                // Mark reminder as sent
                $subscription->update(['reminder_sent' => true]);
            });

        $this->info('Reminders sent successfully.');
    }
}
