<?php

namespace App\Policies;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Sereny\NovaPermissions\Policies\BasePolicy;

class StatusPolicy extends BasePolicy
{
    public $key = 'Status';

    /**
     * @param  Model  $user
     * @param  Status  $model
     * @return bool|mixed
     */
    public function delete(Model $user, $model)
    {
        if ($model->is_default || $model->is_final) {
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
     * @param  Status  $model
     * @return bool|mixed
     */
    public function forceDelete(Model $user, $model)
    {
        if ($model->is_default || $model->is_final) {
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
