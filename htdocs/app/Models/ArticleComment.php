<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleComment extends Model
{
    use SoftDeletes;

    protected $table = 'articles_comments';

    protected $fillable = ['article_id', 'left_key', 'right_key', 'level', 'username', 'text', 'parent_id'];

}
