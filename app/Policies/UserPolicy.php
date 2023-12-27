<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Sereny\NovaPermissions\Policies\BasePolicy;

class UserPolicy extends BasePolicy
{
    public $key = 'User';

    /**
     * @param  Model  $user
     * @param  User  $model
     * @return bool|mixed
     */
    public function view(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'view')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return (int) $user->id === (int) $model->id;
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  User  $model
     * @return bool|mixed
     */
    public function update(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'update')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return (int) $user->id === (int) $model->id;
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  User  $model
     * @return bool|mixed
     */
    public function restore(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'restore')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return (int) $user->id === (int) $model->id;
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  User  $model
     * @return bool|mixed
     */
    public function delete(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'delete')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return (int) $user->id === (int) $model->id;
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  User  $model
     * @return bool|mixed
     */
    public function forceDelete(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'forceDelete')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return (int) $user->id === (int) $model->id;
            }
            return true;
        }

        return false;
    }
}
