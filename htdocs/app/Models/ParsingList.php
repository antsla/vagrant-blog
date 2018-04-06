<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParsingList extends Model
{
    protected $table = 'parsing_list_tables';

    protected $fillabel = ['postfix', 'created_at', 'updated_at'];

    public $timestamps = true;
}
