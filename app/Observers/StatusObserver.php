<?php

namespace App\Observers;

use App\Models\Status;
use Exception;

class StatusObserver
{
    public function creating(Status $status): void
    {
        if ($status->is_default && $status->is_final) {
            throw new Exception('A status cannot be both default and final.');
        }
        if ($status->is_default) {
            Status::where('id', '!=', $status->id)
                ->update(['is_default' => false]);
        }
        if ($status->is_final) {
            Status::where('id', '!=', $status->id)
                ->update(['is_final' => false]);
        }
    }

    public function updated(Status $status): void
    {
        //
    }

    public function deleted(Status $status): void
    {
        //
    }

    public function restored(Status $status): void
    {
        //
    }

    public function forceDeleted(Status $status): void
    {
        //
    }
}
