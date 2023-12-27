<?php

namespace App\Policies;

use App\Models\Priority;
use Illuminate\Database\Eloquent\Model;
use Sereny\NovaPermissions\Policies\BasePolicy;

class PriorityPolicy extends BasePolicy
{
    public $key = 'Priority';

    /**
     * @param  Model  $user
     * @param  Priority  $model
     * @return bool|mixed
     */
    public function delete(Model $user, $model)
    {
        if ($model->is_default) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'delete')) {
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Priority  $model
     * @return bool|mixed
     */
    public function forceDelete(Model $user, $model)
    {
        if ($model->is_default) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'forceDelete')) {
            return true;
        }

        return false;
    }
}
