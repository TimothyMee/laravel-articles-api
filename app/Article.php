<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
class Article extends Model implements Searchable
{
    use SoftDeletes;
    protected $fillable = ['title', 'year', 'author', 'article_type'];

    public function rating()
    {
        return $this->hasOne('App\Rating');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('article.one', $this->id);

        return new SearchResult(
            $this,
            $this->title,
            $url
         );
    }
}
