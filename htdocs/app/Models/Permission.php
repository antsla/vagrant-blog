<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    public function roles()
    {
        return $this->belongsTo('App\Models\Role', 'roles2permissions');
    }
}
