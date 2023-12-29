<?php

namespace App\Policies;

use Sereny\NovaPermissions\Policies\BasePolicy;

class CommentPolicy extends BasePolicy
{
    public $key = 'Comment';

    // TODO добавить проверку на приватность комментария и управления своими комментариями
}
