<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'comment_id'
    ];

    protected $table = 'attachments';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
