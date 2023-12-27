<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Priority extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'name',
        'color',
        'sort',
        'is_default',
    ];

    protected $table = 'priorities';

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    protected static function booted()
    {
        static::saving(static function ($priority) {
            if ($priority->is_default) {
                Priority::where('id', '!=', $priority->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
