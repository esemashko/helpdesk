<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    public function creating(Comment $comment): void
    {
        $comment->author_id = auth()->id();
    }

    public function updating(Comment $comment): void
    {
        $comment->updated_by = auth()->id();
    }

    public function deleted(Comment $comment): void
    {
        //
    }

    public function restored(Comment $comment): void
    {
        //
    }

    public function forceDeleted(Comment $comment): void
    {
        //
    }
}
