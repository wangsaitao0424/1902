<?php

namespace App\index;

use Illuminate\Database\Eloquent\Model;

class Index_Car extends Model
{
     protected $table = 'index_car';
    protected $primaryKey='car_id';
    public $timestamps=false;
    protected $fillable = ['user_id','goods_id','buy_number','insert_time'];
}
