<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Quiz;
use App\Models\QuizSubscriber;
use App\Models\Tenant;
use App\Policies\QuizPolicy;
use App\Policies\QuizSubscriberPolicy;
use App\Policies\TenantPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Tenant::class => TenantPolicy::class,
        Quiz::class => QuizPolicy::class,
        QuizSubscriber::class => QuizSubscriberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
