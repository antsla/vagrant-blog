<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy
{
    use HandlesAuthorization;

    public function responseToReview(User $oUser)
    {
        return $oUser->canDo('FEEDBACK_RESPONSE');
    }
}
