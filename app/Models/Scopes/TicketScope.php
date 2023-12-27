<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TicketScope implements Scope
{
    private $user;
    private string $key = 'Ticket';

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

        if ($this->user->hasPermissionTo('viewOwn'.$this->key)) {
            $builder
                ->where('client_id', $this->user->id)
                ->orWhere('author_id', $this->user->id);
        }
    }
}
