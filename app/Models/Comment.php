<?php

namespace App\Models;

use App\Models\Scopes\TicketScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'priority_id',
        'client_id',
        'company_id',
        'status_id',
        'responsible_id',
    ];

    protected $table = 'comments';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status_updated_at' => 'datetime',
        'resolution_deadline' => 'datetime',
        'response_date' => 'datetime',
        'first_response' => 'datetime',
        'closed_date' => 'datetime'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TicketScope());
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
