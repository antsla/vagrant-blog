<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleCategoryPolicy
{
    use HandlesAuthorization;

    public function changeArticleCategory(User $oUser)
    {
        return $oUser->canDo('EDIT_ARTICLES_CATEGORIES');
    }
}
