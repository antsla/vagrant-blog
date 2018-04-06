<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';

    protected $fillable = ['title', 'text', 'group_id', 'created_at', 'updated_at'];

    public function comments()
    {
        return $this->hasMany('App\Models\ArticleComment', 'article_id', 'id')->withTrashed();
    }

    public function group()
    {
        return $this->belongsTo('App\Models\ArticleCategory');
    }
}
