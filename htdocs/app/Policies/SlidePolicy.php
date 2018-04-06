<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlidePolicy
{
    use HandlesAuthorization;

    public function changeSlider(User $oUser)
    {
        return $oUser->canDo('EDIT_SLIDER');
    }
}
