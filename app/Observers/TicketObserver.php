<?php

namespace App\Observers;

use App\Models\Status;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketObserver
{
    public function creating(Ticket $ticket): void
    {
        if (!$ticket->status_id) {
            $defaultStatus = Status::where('is_default', true)->first();
            if ($defaultStatus) {
                $ticket->status_id = $defaultStatus->id;
            }
        }

        $ticket->author_id = auth()->id();
        $ticket->status_updated_at = now();
        $ticket->guid = Str::uuid();
    }

    public function updating(Ticket $ticket): void
    {
        $ticket->updated_by = auth()->id();
        if ($ticket->isDirty('status')) {
            $ticket->status_updated_at = now();
        }
    }

    public function deleted(Ticket $ticket): void
    {
        //
    }

    public function restored(Ticket $ticket): void
    {
        //
    }

    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
