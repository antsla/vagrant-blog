<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function changeArticle(User $oUser)
    {
        return $oUser->canDo('EDIT_ARTICLES');
    }
}
