<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected $primaryKey='article_id';
    public 	  $timestamps = false;
    protected $fillable = ['title','author','content','insert_time'];
}
