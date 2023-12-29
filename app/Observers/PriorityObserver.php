<?php

namespace App\Observers;

use App\Models\Priority;

class PriorityObserver
{
    public function creating(Priority $priority): void
    {
        if ($priority->is_default) {
            Priority::where('id', '!=', $priority->id)
                ->update(['is_default' => false]);
        }
    }

    public function updated(Priority $priority): void
    {
        //
    }

    public function deleted(Priority $priority): void
    {
        //
    }

    public function restored(Priority $priority): void
    {
        //
    }

    public function forceDeleted(Priority $priority): void
    {
        //
    }
}
