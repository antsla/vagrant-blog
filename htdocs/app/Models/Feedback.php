<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['name', 'email', 'text'];
}
