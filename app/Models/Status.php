<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Status extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];
    protected $fillable = [
        'name',
        'button',
        'color',
        'sort',
        'is_default',
        'is_final',
    ];
    protected $table = 'statuses';

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
