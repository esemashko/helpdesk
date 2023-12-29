<?php

namespace App\Observers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentObserver
{
    public function creating(Attachment $attachment): void
    {
        $attachment->created_by = auth()->id();

        $path = $attachment->file_path;

        $fileInfo = pathinfo($path);
        $fileType = $fileInfo['extension'];
        $fileName = $fileInfo['basename'];
        $fileSize = Storage::disk('public')->size($path);
        $fileMimetype = Storage::disk('public')->mimeType($path);

        $attachment->file_name = $fileName;
        $attachment->file_type = $fileType;
        $attachment->file_size = $fileSize;
        $attachment->file_extension = $fileType;
        $attachment->file_mime_type = $fileMimetype;
    }

    public function updating(Attachment $attachment): void
    {
        $attachment->updated_by = auth()->id();
    }

    public function deleted(Attachment $attachment): void
    {
        //
    }

    public function restored(Attachment $attachment): void
    {
        //
    }

    public function forceDeleted(Attachment $attachment): void
    {
        //
    }
}
