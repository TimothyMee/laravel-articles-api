<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['no_of_raters', 'total_ratings', 'average_rating', 'article_id'];
}
