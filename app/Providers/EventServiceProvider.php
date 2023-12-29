<?php

namespace App\Providers;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use App\Observers\AttachmentObserver;
use App\Observers\CommentObserver;
use App\Observers\PriorityObserver;
use App\Observers\StatusObserver;
use App\Observers\TicketObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Ticket::observe(TicketObserver::class);
        Priority::observe(PriorityObserver::class);
        Status::observe(StatusObserver::class);
        Comment::observe(CommentObserver::class);
        Attachment::observe(AttachmentObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
