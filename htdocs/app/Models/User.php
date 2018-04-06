<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Проверка пользователя на необходимые права
     *
     * @param string $sPermission название права
     * @return bool
     */
    public function canDo($sPermission)
    {
        foreach ($this->role->perms as $perm) {
            if (str_is($sPermission, $perm->name)) {
                return true;
            }
        }
        return false;
    }
}
