<?php

namespace App\Models;

use App\Models\Scopes\TicketScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class Ticket extends Model
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

    protected $table = 'tickets';

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
        static::creating(function ($ticket) {
            if (!$ticket->status_id) {
                $defaultStatus = Status::where('is_default', true)->first();
                if ($defaultStatus) {
                    $ticket->status_id = $defaultStatus->id;
                }
            }
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->author_id = auth()->id();
            $model->status_updated_at = Date::now();
            $model->guid = Str::uuid();
        });

        static::updating(static function ($model) {
            $model->updated_by = auth()->id();
            if ($model->isDirty('status')) {
                $model->status_updated_at = Date::now();
            }
        });
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class);
    }
}
