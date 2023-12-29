<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\AttachmentPolicy;
use App\Policies\CommentPolicy;
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
        Status::class => PriorityPolicy::class,
        Comment::class => CommentPolicy::class,
        Attachment::class => AttachmentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
