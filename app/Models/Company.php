<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'website',
        'address',
        'description'
    ];

    protected $table = 'companies';

    protected static function boot(): void
    {
        parent::boot();
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_id', 'user_id');
    }
}
