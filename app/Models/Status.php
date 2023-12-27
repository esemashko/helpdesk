<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Status extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'name',
        'button',
        'color',
        'sort',
        'is_default',
        'is_final',
    ];

    protected $table = 'statuses';

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    protected static function booted()
    {
        static::saving(static function ($status) {
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
        });
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
