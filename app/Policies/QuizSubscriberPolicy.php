<?php

namespace App\Policies;

use App\Models\QuizSubscriber;
use App\Models\TenantUser;

class QuizSubscriberPolicy
{
    // Check if user own the QuizSubscriber model
    public function view(TenantUser $user, QuizSubscriber $quizSubscriber)
    {
        return $quizSubscriber->tenant_user_id === $user->id;
    }

}
