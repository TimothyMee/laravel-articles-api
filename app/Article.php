<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'year', 'author', 'article_type'];

    public function rating()
    {
        return $this->hasOne('App\Rating');
    }
}
