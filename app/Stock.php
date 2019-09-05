<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey='stock_id';
    public 	  $timestamps = false;
    protected $fillable = ['stock_name','goods_img','insert_time','stock_num'];
}
