<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope
{
    private $user;
    private string $key = 'Company';

    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (!$this->user) {
            return;
        }

        if ($this->user->isSuperAdmin()) {
            return;
        }

        if ($this->user->hasPermissionTo('viewOwn' . $this->key)) {
            $builder
                ->whereIn('companies.id', function ($query) {
                    $query->select('company_id')
                        ->from('company_user')
                        ->where('user_id', $this->user->id);
                });
        }
    }
}
