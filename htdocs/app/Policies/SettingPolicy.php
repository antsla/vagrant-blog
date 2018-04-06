<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function changeSetting(User $oUser)
    {
        return $oUser->canDo('EDIT_SETTINGS');
    }
}
