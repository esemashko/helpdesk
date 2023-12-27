<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Company;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\CompanyPolicy;
use App\Policies\PriorityPolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Company::class => CompanyPolicy::class,
        Ticket::class => TicketPolicy::class,
        User::class => UserPolicy::class,
        Priority::class => PriorityPolicy::class,
        // \App\Models\Status::class => \App\Policies\StatusPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
