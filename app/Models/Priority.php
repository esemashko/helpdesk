<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Priority extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];
    protected $fillable = [
        'name',
        'color',
        'sort',
        'is_default',
    ];
    protected $table = 'priorities';

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
