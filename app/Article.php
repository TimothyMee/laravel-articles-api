<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'year', 'author', 'article_type'];
}
