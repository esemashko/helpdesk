<?php

namespace App\Policies;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Sereny\NovaPermissions\Policies\BasePolicy;

class TicketPolicy extends BasePolicy
{
    public $key = 'Ticket';

    /**
     * @param  Model  $user
     * @param  Ticket  $model
     * @return bool|mixed
     */
    public function view(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'view')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                $isClient = (int) $model->client_id === (int) $user->id;
                $isAuthor = (int) $model->author_id === (int) $user->id;

                return $isClient || $isAuthor;
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Ticket  $model
     * @return bool|mixed
     */
    public function update(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'update')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                $isClient = (int) $model->client_id === (int) $user->id;
                $isAuthor = (int) $model->author_id === (int) $user->id;

                return $isClient || $isAuthor;
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Ticket  $model
     * @return bool|mixed
     */
    public function restore(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'restore')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                $isClient = (int) $model->client_id === (int) $user->id;
                $isAuthor = (int) $model->author_id === (int) $user->id;

                return $isClient || $isAuthor;
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Ticket  $model
     * @return bool|mixed
     */
    public function delete(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'delete')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                $isClient = (int) $model->client_id === (int) $user->id;
                $isAuthor = (int) $model->author_id === (int) $user->id;

                return $isClient || $isAuthor;
            }
            return true;
        }

        return false;
    }

    /**
     * @param  Model  $user
     * @param  Ticket  $model
     * @return bool|mixed
     */
    public function forceDelete(Model $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->hasPermissionTo($user, 'forceDelete')) {
            if ($this->hasPermissionTo($user, 'viewOwn')) {
                $isClient = (int) $model->client_id === (int) $user->id;
                $isAuthor = (int) $model->author_id === (int) $user->id;

                return $isClient || $isAuthor;
            }
            return true;
        }

        return false;
    }
}
