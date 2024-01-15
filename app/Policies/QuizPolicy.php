<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\TenantUser;

class QuizPolicy
{
    public function subscribe(TenantUser $user, Quiz $quiz)
    {
        return !$quiz->subscribers->contains($user);
    }

    public function unSubscribe(TenantUser $user, Quiz $quiz)
    {
        return $quiz->subscribers->contains($user);
    }

    public function isSubscribable(TenantUser $user, Quiz $quiz)
    {
        return $quiz->is_subscribable;
    }

}
