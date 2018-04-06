<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParsingPolicy
{
    use HandlesAuthorization;

    public function parsingFiles(User $oUser)
    {
        return $oUser->canDo('PARSING_FILES');
    }
}
