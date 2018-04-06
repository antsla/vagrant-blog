<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $table = 'articles_categories';

    protected $fillable = ['title', 'parent_id', 'level', 'path', 'created_at', 'updated_at'];

    public function articles()
    {
        return $this->hasMany('App\Models\Articles');
    }
}
