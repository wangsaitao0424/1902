<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table='admin_goods';
    protected $primaryKey='goods_id';
    public    $timestamps=false;
    protected $fillable = ['goods_name','goods_sn','cat_id','brand_id','shop_price','goods_number','goods_img','is_on_sale','insert_time','goods_desc','is_hat','is_new'];
}
