<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function changeUserStatus(User $oUser)
    {
        return $oUser->canDo('EDIT_USERS');
    }
}
