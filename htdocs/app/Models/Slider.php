<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $timestamps = false;

    protected $table = 'slider';

    protected $fillable = ['img', 'text', 'sort'];
}
