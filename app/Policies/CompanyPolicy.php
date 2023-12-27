<?php

namespace App\Policies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Sereny\NovaPermissions\Policies\BasePolicy;

class CompanyPolicy extends BasePolicy
{
    public $key = 'Company';
    private const COMPANY_SUPPORT_ID = 1;

    /**
     * @param  Model  $user
     * @param  Company  $model
     * @return bool|mixed
     */
    public function view(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'view')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return $user->companies->pluck('id')->contains($model->id);
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Company  $model
     * @return bool|mixed
     */
    public function update(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'update')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return $user->companies->pluck('id')->contains($model->id);
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Company  $model
     * @return bool|mixed
     */
    public function restore(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'restore')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return $user->companies->pluck('id')->contains($model->id);
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Company  $model
     * @return bool|mixed
     */
    public function delete(Model $user, $model)
    {
        if ((int) $model->id === self::COMPANY_SUPPORT_ID) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'delete')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return $user->companies->pluck('id')->contains($model->id);
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Company  $model
     * @return bool|mixed
     */
    public function forceDelete(Model $user, $model)
    {
        if ((int) $model->id === self::COMPANY_SUPPORT_ID) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'forceDelete')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                return $user->companies->pluck('id')->contains($model->id);
            }
            return true;
        }

        return false;
    }
}
